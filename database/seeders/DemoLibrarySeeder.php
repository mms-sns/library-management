<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Floor;
use App\Models\IDCard;
use App\Models\Library;
use App\Models\LibrarySetting;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Room;
use App\Models\SaaSPackage;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\Student;
use App\Models\StudentGuardian;
use App\Models\TenantSubscription;
use App\Models\User;
use App\Services\AttendanceService;
use App\Services\IDCardService;
use App\Services\InvoiceService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoLibrarySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@saas.com'],
            [
                'name' => 'SaaS Super Admin',
                'password' => Hash::make('password'),
                'mobile' => '9876543210',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('super_admin');

        // 1.1 Seed Default SaaS Subscription Packages
        $pkgStarter = SaaSPackage::firstOrCreate(
            ['slug' => 'starter-tier'],
            [
                'name' => 'Starter Tier',
                'description' => 'Perfect for single branch study centers up to 50 seats',
                'monthly_price' => 999.00,
                'yearly_price' => 9990.00,
                'max_branches' => 1,
                'max_seats' => 50,
                'max_students' => 100,
                'status' => 'active',
            ]
        );

        $pkgGrowth = SaaSPackage::firstOrCreate(
            ['slug' => 'growth-tier'],
            [
                'name' => 'Growth Tier',
                'description' => 'Ideal for multi-branch libraries with up to 200 seats',
                'monthly_price' => 2499.00,
                'yearly_price' => 24990.00,
                'max_branches' => 3,
                'max_seats' => 200,
                'max_students' => 500,
                'status' => 'active',
            ]
        );

        $pkgEnterprise = SaaSPackage::firstOrCreate(
            ['slug' => 'enterprise-tier'],
            [
                'name' => 'Enterprise Unlimited Tier',
                'description' => 'Unlimited branches, seats, and student check-ins with priority support',
                'monthly_price' => 4999.00,
                'yearly_price' => 49990.00,
                'max_branches' => 0,
                'max_seats' => 0,
                'max_students' => 0,
                'status' => 'active',
            ]
        );

        // 2. Create Demo Library
        $library = Library::firstOrCreate(
            ['slug' => 'apex-study-center'],
            [
                'name' => 'Apex Study Center & Reading Room',
                'email' => 'contact@apexlibrary.com',
                'mobile' => '9810098100',
                'address' => '12 Barakhamba Road, Connaught Place',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'status' => 'active',
            ]
        );

        // Attach Growth Tier subscription to Demo Library
        TenantSubscription::firstOrCreate(
            ['library_id' => $library->id, 'saas_package_id' => $pkgGrowth->id],
            [
                'billing_cycle' => 'monthly',
                'price' => 2499.00,
                'starts_at' => now()->startOfMonth()->toDateString(),
                'ends_at' => now()->startOfMonth()->addDays(30)->toDateString(),
                'status' => 'active',
            ]
        );

        // 3. Create Library Settings
        LibrarySetting::firstOrCreate(
            ['library_id' => $library->id],
            [
                'timezone' => 'Asia/Kolkata',
                'currency' => 'INR',
                'date_format' => 'DD-MM-YYYY',
                'time_format' => '12h',
                'opening_time' => '06:00:00',
                'closing_time' => '23:00:00',
                'duplicate_scan_delay_seconds' => 60,
                'grace_period_days' => 2,
                'gst_enabled' => true,
                'gst_number' => '07AAAAA0000A1Z5',
                'tax_rate' => 18.00,
            ]
        );

        // 4. Create Library Owner
        $owner = User::firstOrCreate(
            ['email' => 'owner@apexlibrary.com'],
            [
                'library_id' => $library->id,
                'name' => 'Rajesh Kumar',
                'password' => Hash::make('password'),
                'mobile' => '9810012345',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $owner->assignRole('library_owner');

        // 5. Create Branches
        $branch1 = Branch::firstOrCreate(
            ['library_id' => $library->id, 'code' => 'CP-01'],
            [
                'name' => 'Main Branch - Connaught Place',
                'address' => '12 Barakhamba Road',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'phone' => '011-23456789',
                'status' => 'active',
            ]
        );

        $branch2 = Branch::firstOrCreate(
            ['library_id' => $library->id, 'code' => 'NC-02'],
            [
                'name' => 'North Campus Branch',
                'address' => '45 Hudson Lane, GTB Nagar',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110009',
                'phone' => '011-23456790',
                'status' => 'active',
            ]
        );

        // 6. Create Branch Manager
        $manager = User::firstOrCreate(
            ['email' => 'manager@apexlibrary.com'],
            [
                'library_id' => $library->id,
                'name' => 'Amit Sharma',
                'password' => Hash::make('password'),
                'mobile' => '9810054321',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $manager->assignRole('branch_manager');
        $manager->branches()->syncWithoutDetaching([$branch1->id]);

        // 7. Create Staff Member
        $staff = User::firstOrCreate(
            ['email' => 'staff@apexlibrary.com'],
            [
                'library_id' => $library->id,
                'name' => 'Priya Singh',
                'password' => Hash::make('password'),
                'mobile' => '9810067890',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $staff->assignRole('staff');
        $staff->branches()->syncWithoutDetaching([$branch1->id, $branch2->id]);

        // 8. Seed Demo Students (Phase 2)
        $studentsData = [
            [
                'student_number' => 'LIB-000001',
                'first_name' => 'Rahul',
                'last_name' => 'Sharma',
                'gender' => 'male',
                'date_of_birth' => '2002-05-14',
                'mobile' => '9810011111',
                'email' => 'rahul.sharma@gmail.com',
                'address' => 'House No. 12, Connaught Place',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110001',
                'status' => 'active',
                'joined_at' => '2026-09-01',
                'guardian' => [
                    'name' => 'Suresh Sharma',
                    'relationship' => 'Father',
                    'mobile' => '9810011112',
                ],
            ],
            [
                'student_number' => 'LIB-000002',
                'first_name' => 'Ananya',
                'last_name' => 'Verma',
                'gender' => 'female',
                'date_of_birth' => '2003-11-20',
                'mobile' => '9810022222',
                'email' => 'ananya.verma@gmail.com',
                'address' => 'Flat 402, GTB Nagar',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110009',
                'status' => 'active',
                'joined_at' => '2026-09-05',
                'guardian' => [
                    'name' => 'Ramesh Verma',
                    'relationship' => 'Father',
                    'mobile' => '9810022223',
                ],
            ],
            [
                'student_number' => 'LIB-000003',
                'first_name' => 'Vikas',
                'last_name' => 'Yadav',
                'gender' => 'male',
                'date_of_birth' => '2001-08-10',
                'mobile' => '9810033333',
                'email' => 'vikas.yadav@gmail.com',
                'address' => 'Plot 88, Karol Bagh',
                'city' => 'New Delhi',
                'state' => 'Delhi',
                'pincode' => '110005',
                'status' => 'suspended',
                'joined_at' => '2026-08-15',
                'guardian' => [
                    'name' => 'Sunita Yadav',
                    'relationship' => 'Mother',
                    'mobile' => '9810033334',
                ],
            ],
        ];

        $createdStudents = [];
        foreach ($studentsData as $stData) {
            $guardianData = $stData['guardian'];
            unset($stData['guardian']);

            $student = Student::firstOrCreate(
                ['library_id' => $library->id, 'student_number' => $stData['student_number']],
                $stData
            );

            StudentGuardian::firstOrCreate(
                ['student_id' => $student->id],
                [
                    'name' => $guardianData['name'],
                    'relationship' => $guardianData['relationship'],
                    'mobile' => $guardianData['mobile'],
                ]
            );

            $createdStudents[] = $student;
        }

        // 9. Seed Demo Seat Types (Phase 3)
        $seatTypeNormal = SeatType::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Normal Seat'],
            ['description' => 'Standard self-study desk', 'monthly_price' => 1200.00, 'status' => 'active']
        );

        $seatTypeAC = SeatType::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Premium AC Seat'],
            ['description' => 'Air-conditioned reserved desk with personal power outlet', 'monthly_price' => 1800.00, 'status' => 'active']
        );

        $seatTypeCabin = SeatType::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Private Cabin Seat'],
            ['description' => 'Soundproof private study partition with reading lamp', 'monthly_price' => 2500.00, 'status' => 'active']
        );

        // 10. Seed Demo Floors & Rooms
        $floor1 = Floor::firstOrCreate(
            ['branch_id' => $branch1->id, 'floor_number' => 0],
            ['name' => 'Ground Floor', 'sort_order' => 1, 'status' => 'active']
        );
        $floor2 = Floor::firstOrCreate(
            ['branch_id' => $branch1->id, 'floor_number' => 1],
            ['name' => 'First Floor', 'sort_order' => 2, 'status' => 'active']
        );

        $roomA = Room::firstOrCreate(
            ['branch_id' => $branch1->id, 'code' => 'HALL-A'],
            ['floor_id' => $floor1->id, 'name' => 'Silent Study Hall A', 'capacity' => 20, 'status' => 'active']
        );

        $roomB = Room::firstOrCreate(
            ['branch_id' => $branch1->id, 'code' => 'CAB-B'],
            ['floor_id' => $floor2->id, 'name' => 'AC Cabin Room B', 'capacity' => 10, 'status' => 'active']
        );

        // 11. Seed Demo Seats (30+ seats)
        for ($i = 1; $i <= 20; $i++) {
            $seatNum = sprintf('A-%02d', $i);
            $status = $i <= 8 ? 'occupied' : ($i === 9 || $i === 10 ? 'reserved' : ($i === 11 ? 'maintenance' : 'available'));
            $type = $i <= 10 ? $seatTypeAC->id : $seatTypeNormal->id;

            Seat::firstOrCreate(
                ['branch_id' => $branch1->id, 'seat_number' => $seatNum],
                [
                    'floor_id' => $floor1->id,
                    'room_id' => $roomA->id,
                    'seat_type_id' => $type,
                    'status' => $status,
                ]
            );
        }

        for ($i = 1; $i <= 10; $i++) {
            $seatNum = sprintf('CAB-%02d', $i);
            $status = $i <= 3 ? 'occupied' : 'available';

            Seat::firstOrCreate(
                ['branch_id' => $branch1->id, 'seat_number' => $seatNum],
                [
                    'floor_id' => $floor2->id,
                    'room_id' => $roomB->id,
                    'seat_type_id' => $seatTypeCabin->id,
                    'status' => $status,
                ]
            );
        }

        // 12. Seed Demo Membership Plans (Phase 4)
        $planMonthly = MembershipPlan::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Monthly Membership'],
            ['duration_days' => 30, 'price' => 1500.00, 'description' => '30 Days Full Reading Access', 'status' => 'active']
        );

        $planQuarterly = MembershipPlan::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Quarterly Membership'],
            ['duration_days' => 90, 'price' => 4000.00, 'description' => '90 Days Access (Save ₹500)', 'status' => 'active']
        );

        $planHalfYearly = MembershipPlan::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Half Yearly Plan'],
            ['duration_days' => 180, 'price' => 7500.00, 'description' => '180 Days Access (Save ₹1500)', 'status' => 'active']
        );

        $planYearly = MembershipPlan::firstOrCreate(
            ['library_id' => $library->id, 'name' => 'Yearly Membership'],
            ['duration_days' => 365, 'price' => 14000.00, 'description' => '365 Days Access (Best Value)', 'status' => 'active']
        );

        // 13. Seed Demo Memberships for Students
        if (isset($createdStudents[0])) {
            Membership::firstOrCreate(
                ['student_id' => $createdStudents[0]->id, 'membership_plan_id' => $planMonthly->id],
                [
                    'library_id' => $library->id,
                    'branch_id' => $branch1->id,
                    'start_date' => now()->startOfMonth()->format('Y-m-d'),
                    'end_date' => now()->startOfMonth()->addDays(29)->format('Y-m-d'),
                    'price' => 1500.00,
                    'discount' => 100.00,
                    'final_amount' => 1400.00,
                    'status' => 'active',
                    'notes' => 'Initial Monthly Admission',
                ]
            );
        }

        if (isset($createdStudents[1])) {
            Membership::firstOrCreate(
                ['student_id' => $createdStudents[1]->id, 'membership_plan_id' => $planQuarterly->id],
                [
                    'library_id' => $library->id,
                    'branch_id' => $branch1->id,
                    'start_date' => now()->subDays(15)->format('Y-m-d'),
                    'end_date' => now()->addDays(74)->format('Y-m-d'),
                    'price' => 4000.00,
                    'discount' => 0.00,
                    'final_amount' => 4000.00,
                    'status' => 'active',
                    'notes' => 'Quarterly Package',
                ]
            );
        }

        // 14. Seed Invoices & Payments (Phase 5)
        $invoiceService = app(InvoiceService::class);
        if (isset($createdStudents[0])) {
            $inv1 = $invoiceService->createInvoice([
                'library_id' => $library->id,
                'branch_id' => $branch1->id,
                'student_id' => $createdStudents[0]->id,
                'invoice_date' => now()->startOfMonth()->format('Y-m-d'),
                'due_date' => now()->startOfMonth()->addDays(7)->format('Y-m-d'),
                'discount' => 100.00,
                'tax' => 252.00, // 18% GST on 1400 subtotal
                'notes' => 'Monthly Fee Invoice + Admission',
            ], [
                ['description' => 'Monthly Library Membership Fee', 'quantity' => 1, 'unit_price' => 1500.00],
            ]);

            $invoiceService->recordPayment($inv1, [
                'amount' => 1652.00,
                'payment_method' => 'upi',
                'transaction_reference' => 'UPI/987654321001',
                'payment_date' => now()->startOfMonth()->toDateTimeString(),
                'received_by' => $owner->id,
                'notes' => 'Full payment received via PhonePe QR',
            ]);
        }

        if (isset($createdStudents[1])) {
            $inv2 = $invoiceService->createInvoice([
                'library_id' => $library->id,
                'branch_id' => $branch1->id,
                'student_id' => $createdStudents[1]->id,
                'invoice_date' => now()->subDays(10)->format('Y-m-d'),
                'due_date' => now()->addDays(5)->format('Y-m-d'),
                'discount' => 0.00,
                'tax' => 720.00, // 18% GST on 4000
                'notes' => 'Quarterly Membership Invoice',
            ], [
                ['description' => 'Quarterly Library Desk Plan', 'quantity' => 1, 'unit_price' => 4000.00],
            ]);

            $invoiceService->recordPayment($inv2, [
                'amount' => 2000.00,
                'payment_method' => 'cash',
                'transaction_reference' => null,
                'payment_date' => now()->subDays(10)->toDateTimeString(),
                'received_by' => $owner->id,
                'notes' => 'Partial cash payment received on registration',
            ]);
        }

        // 15. Seed ID Cards & QR Tokens (Phase 6)
        $idCardService = app(IDCardService::class);
        foreach ($createdStudents as $st) {
            if (!IDCard::where('student_id', $st->id)->where('status', 'active')->exists()) {
                $idCardService->issueCard($st, [
                    'issue_date' => now()->subDays(5)->format('Y-m-d'),
                    'expiry_date' => now()->addYear()->format('Y-m-d'),
                    'notes' => 'Identity Card Issued during onboarding',
                ]);
            }
        }

        // 16. Seed Attendance Logs (Phase 7)
        $attendanceService = app(AttendanceService::class);
        if (isset($createdStudents[0])) {
            // Student 0: Presently checked in
            $attendanceService->checkIn($createdStudents[0], [
                'branch_id' => $branch1->id,
                'check_in_at' => now()->subHours(2),
                'method' => 'qr_scan',
                'notes' => 'Morning study session check-in',
            ]);
        }

        if (isset($createdStudents[1])) {
            // Student 1: Checked out after 4 hours
            $att = $attendanceService->checkIn($createdStudents[1], [
                'branch_id' => $branch1->id,
                'check_in_at' => now()->subHours(5),
                'method' => 'kiosk',
                'notes' => 'Kiosk check-in',
            ]);

            $attendanceService->checkOut($att, [
                'check_out_at' => now()->subHour(),
                'status' => 'checked_out',
            ]);
        }
    }
}
