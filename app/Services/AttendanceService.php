<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\IDCard;
use App\Models\Membership;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Check in a student
     */
    public function checkIn(Student $student, array $data = []): Attendance
    {
        return DB::transaction(function () use ($student, $data) {
            // Check if already checked in (present)
            $existing = Attendance::where('student_id', $student->id)
                ->where('status', 'present')
                ->first();

            if ($existing) {
                return $existing;
            }

            // Find active membership seat if applicable
            $activeMembership = Membership::where('student_id', $student->id)
                ->where('status', 'active')
                ->latest()
                ->first();

            $branchId = $data['branch_id']
                ?? $student->memberships()->latest()->value('branch_id')
                ?? \App\Models\Branch::where('library_id', $student->library_id)->value('id');

            $seatId = $data['seat_id'] ?? $student->seat_id ?? $activeMembership?->seat_id;
            $idCardId = $data['id_card_id'] ?? $student->activeIdCard?->id;

            return Attendance::create([
                'library_id' => $student->library_id,
                'branch_id' => $branchId,
                'student_id' => $student->id,
                'id_card_id' => $idCardId,
                'seat_id' => $seatId,
                'check_in_at' => $data['check_in_at'] ?? now(),
                'status' => 'present',
                'method' => $data['method'] ?? 'manual',
                'notes' => $data['notes'] ?? null,
            ]);
        });
    }

    /**
     * Check out a student or attendance record
     */
    public function checkOut(Attendance|Student $target, array $data = []): Attendance
    {
        $attendance = $target instanceof Student
            ? Attendance::where('student_id', $target->id)->where('status', 'present')->firstOrFail()
            : $target;

        $checkOutAt = $data['check_out_at'] ?? now();
        $status = $data['status'] ?? 'checked_out';

        $attendance->update([
            'check_out_at' => $checkOutAt,
            'status' => $status,
            'notes' => $data['notes'] ?? $attendance->notes,
        ]);

        return $attendance;
    }

    /**
     * Process instant QR Code scan or Student Number input from Kiosk
     */
    public function processScan(string $inputToken, int $branchId): array
    {
        $token = trim($inputToken);

        $branch = Branch::find($branchId);
        $libraryId = $branch?->library_id;

        // 1. Match by QR Token on IDCard (globally unique) or Card Number (scoped by library)
        $idCard = IDCard::with(['student', 'library'])
            ->where('qr_token', $token)
            ->orWhere(function ($q) use ($token, $libraryId) {
                $q->where('card_number', $token);
                if ($libraryId) {
                    $q->where('library_id', $libraryId);
                }
            })
            ->first();

        $student = null;
        if ($idCard) {
            if ($idCard->status !== 'active') {
                return [
                    'success' => false,
                    'message' => "ID Card #{$idCard->card_number} is {$idCard->status}. Please contact management.",
                    'action' => 'error',
                ];
            }
            $student = $idCard->student;
        } else {
            // 2. Fallback match by Student Number or Mobile (scoped by library)
            $studentQuery = Student::where(function ($q) use ($token) {
                $q->where('student_number', $token)
                    ->orWhere('mobile', $token);
            });
            if ($libraryId) {
                $studentQuery->where('library_id', $libraryId);
            }
            $student = $studentQuery->first();
        }

        if (!$student) {
            return [
                'success' => false,
                'message' => "Invalid QR code or student number: '{$token}'",
                'action' => 'error',
            ];
        }

        if ($student->status !== 'active') {
            return [
                'success' => false,
                'message' => "Student profile for {$student->full_name} is currently {$student->status}.",
                'action' => 'error',
            ];
        }

        // Check current attendance state
        $activeAttendance = Attendance::where('student_id', $student->id)
            ->where('status', 'present')
            ->first();

        if ($activeAttendance) {
            // Student is present => Perform Check-Out
            $attendance = $this->checkOut($activeAttendance, [
                'method' => 'qr_scan',
            ]);

            return [
                'success' => true,
                'action' => 'check_out',
                'message' => "Goodbye, {$student->full_name}! Checked out successfully.",
                'student' => [
                    'full_name' => $student->full_name,
                    'student_number' => $student->student_number,
                    'photo' => $student->photo,
                ],
                'attendance' => [
                    'check_in' => $attendance->check_in_at->format('h:i A'),
                    'check_out' => $attendance->check_out_at->format('h:i A'),
                    'duration' => $attendance->getFormattedDuration(),
                ],
            ];
        }

        // Student is absent => Perform Check-In
        $attendance = $this->checkIn($student, [
            'branch_id' => $branchId,
            'id_card_id' => $idCard?->id,
            'method' => 'qr_scan',
        ]);

        return [
            'success' => true,
            'action' => 'check_in',
            'message' => "Welcome, {$student->full_name}! Checked in successfully.",
            'student' => [
                'full_name' => $student->full_name,
                'student_number' => $student->student_number,
                'photo' => $student->photo,
            ],
            'attendance' => [
                'check_in' => $attendance->check_in_at->format('h:i A'),
                'time' => $attendance->check_in_at->format('d M Y, h:i A'),
            ],
        ];
    }
}
