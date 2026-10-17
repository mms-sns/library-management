<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Seat;
use App\Models\Student;
use App\Models\StudentGuardian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    /**
     * Generate sequential student number for a library (e.g. LIB-000001)
     */
    public function generateStudentNumber(int $libraryId): string
    {
        return DB::transaction(function () use ($libraryId) {
            $lastStudent = Student::withTrashed()
                ->where('library_id', $libraryId)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;

            if ($lastStudent && preg_match('/LIB-(\d+)/i', $lastStudent->student_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            return sprintf('LIB-%06d', $nextNumber);
        });
    }

    /**
     * Create a new student record along with optional guardian details and photo upload
     */
    public function createStudent(array $data, ?UploadedFile $photoFile = null): Student
    {
        return DB::transaction(function () use ($data, $photoFile) {
            if ($photoFile) {
                $data['photo'] = $photoFile->store('students/photos', 'public');
            }

            if (empty($data['student_number'])) {
                $data['student_number'] = $this->generateStudentNumber($data['library_id']);
            }

            $nonStudentKeys = [
                'guardian_name', 'guardian_relationship', 'guardian_mobile', 
                'guardian_alternate_mobile', 'guardian_email', 'guardian_address',
                'membership_plan_id', 'membership_start_date', 'membership_discount', 
                'membership_payment_status', 'membership_payment_method', 'received_by', 'branch_id'
            ];
            $studentData = array_diff_key($data, array_flip($nonStudentKeys));

            $student = Student::create($studentData);

            if (!empty($studentData['seat_id'])) {
                Seat::where('id', $studentData['seat_id'])->update(['status' => 'occupied']);
            }

            if (!empty($data['guardian_name']) && !empty($data['guardian_mobile'])) {
                StudentGuardian::create([
                    'student_id' => $student->id,
                    'name' => $data['guardian_name'],
                    'relationship' => $data['guardian_relationship'] ?? 'Guardian',
                    'mobile' => $data['guardian_mobile'],
                    'alternate_mobile' => $data['guardian_alternate_mobile'] ?? null,
                    'email' => $data['guardian_email'] ?? null,
                    'address' => $data['guardian_address'] ?? null,
                ]);
            }

            // Membership Plan Enrollment (Optional during student admission)
            if (!empty($data['membership_plan_id'])) {
                $plan = MembershipPlan::find($data['membership_plan_id']);
                if ($plan) {
                    $startDate = !empty($data['membership_start_date'])
                        ? Carbon::parse($data['membership_start_date'])
                        : (!empty($student->joined_at) ? Carbon::parse($student->joined_at) : now());

                    $endDate = (clone $startDate)->addDays($plan->duration_days - 1);
                    $price = floatval($plan->price);
                    $discount = floatval($data['membership_discount'] ?? 0.00);
                    $finalAmount = max(0, $price - $discount);

                    $branchId = null;
                    if (!empty($student->seat_id)) {
                        $branchId = Seat::where('id', $student->seat_id)->value('branch_id');
                    }
                    if (!$branchId) {
                        $branchId = !empty($data['branch_id']) 
                            ? $data['branch_id'] 
                            : Branch::where('library_id', $student->library_id)->value('id');
                    }

                    $membership = Membership::create([
                        'library_id' => $student->library_id,
                        'branch_id' => $branchId,
                        'student_id' => $student->id,
                        'membership_plan_id' => $plan->id,
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'price' => $price,
                        'discount' => $discount,
                        'final_amount' => $finalAmount,
                        'status' => 'active',
                        'notes' => 'Enrolled during student admission',
                    ]);

                    // Generate Admission & Membership Fee Invoice
                    $invoiceService = app(InvoiceService::class);
                    $isPaid = ($data['membership_payment_status'] ?? '') === 'paid';
                    $paymentMethod = $data['membership_payment_method'] ?? 'cash';
                    $receivedBy = $data['received_by'] ?? auth()->id() ?? User::where('library_id', $student->library_id)->value('id');

                    $settings = \App\Models\LibrarySetting::where('library_id', $student->library_id)->first();
                    $taxRate = ($settings && $settings->gst_enabled) ? floatval($settings->tax_rate) : 0.00;
                    $tax = round(($finalAmount * $taxRate) / 100, 2);
                    $totalInvoiceAmount = $finalAmount + $tax;

                    $invoiceService->createInvoice([
                        'library_id' => $student->library_id,
                        'branch_id' => $branchId,
                        'student_id' => $student->id,
                        'membership_id' => $membership->id,
                        'invoice_date' => $startDate->format('Y-m-d'),
                        'due_date' => (clone $startDate)->addDays(7)->format('Y-m-d'),
                        'discount' => $discount,
                        'paid_amount' => $isPaid ? $totalInvoiceAmount : 0.00,
                        'payment_method' => $isPaid ? $paymentMethod : null,
                        'received_by' => $receivedBy,
                        'notes' => "Admission & {$plan->name} fee invoice",
                    ], [
                        [
                            'description' => "{$plan->name} ({$plan->duration_days} Days)",
                            'quantity' => 1,
                            'unit_price' => $price,
                        ]
                    ]);
                }
            }

            return $student;
        });
    }

    /**
     * Update student record & guardian details
     */
    public function updateStudent(Student $student, array $data, ?UploadedFile $photoFile = null): Student
    {
        return DB::transaction(function () use ($student, $data, $photoFile) {
            if ($photoFile) {
                if ($student->photo && Storage::disk('public')->exists($student->photo)) {
                    Storage::disk('public')->delete($student->photo);
                }
                $data['photo'] = $photoFile->store('students/photos', 'public');
            }

            $oldSeatId = $student->seat_id;
            $studentData = array_diff_key($data, array_flip(['guardian_name', 'guardian_relationship', 'guardian_mobile', 'guardian_alternate_mobile', 'guardian_email', 'guardian_address']));

            $student->update($studentData);

            if (array_key_exists('seat_id', $studentData)) {
                $newSeatId = $studentData['seat_id'];
                if ($oldSeatId && $oldSeatId != $newSeatId) {
                    Seat::where('id', $oldSeatId)->update(['status' => 'available']);
                }
                if ($newSeatId && $newSeatId != $oldSeatId) {
                    Seat::where('id', $newSeatId)->update(['status' => 'occupied']);
                }
            }

            if (!empty($data['guardian_name']) && !empty($data['guardian_mobile'])) {
                $student->guardian()->updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'name' => $data['guardian_name'],
                        'relationship' => $data['guardian_relationship'] ?? 'Guardian',
                        'mobile' => $data['guardian_mobile'],
                        'alternate_mobile' => $data['guardian_alternate_mobile'] ?? null,
                        'email' => $data['guardian_email'] ?? null,
                        'address' => $data['guardian_address'] ?? null,
                    ]
                );
            }

            return $student;
        });
    }
}
