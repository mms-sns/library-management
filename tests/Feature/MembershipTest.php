<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Library;
use App\Models\Membership;
use App\Models\MembershipPlan;
use App\Models\Student;
use App\Models\User;
use App\Services\MembershipService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MembershipTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_membership_creation_calculates_end_date_correctly(): void
    {
        $library = Library::create([
            'name' => 'Library Alpha',
            'slug' => 'lib-alpha',
            'email' => 'alpha@test.com',
            'mobile' => '9999999999',
            'status' => 'active',
        ]);
        $branch = Branch::create([
            'library_id' => $library->id,
            'name' => 'Main Branch',
            'code' => 'MB-01',
            'status' => 'active',
        ]);
        $student = Student::create([
            'library_id' => $library->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Rahul',
            'mobile' => '9810011111',
            'status' => 'active',
            'joined_at' => now(),
        ]);
        $plan = MembershipPlan::create([
            'library_id' => $library->id,
            'name' => '30 Days Plan',
            'duration_days' => 30,
            'price' => 1500.00,
            'status' => 'active',
        ]);

        $service = new MembershipService();
        $membership = $service->createMembership([
            'library_id' => $library->id,
            'branch_id' => $branch->id,
            'student_id' => $student->id,
            'membership_plan_id' => $plan->id,
            'start_date' => '2026-10-01',
            'price' => 1500.00,
            'discount' => 100.00,
            'status' => 'active',
        ]);

        $this->assertEquals('2026-10-01', $membership->start_date->format('Y-m-d'));
        // 30 days starting Oct 1 -> Oct 30
        $this->assertEquals('2026-10-30', $membership->end_date->format('Y-m-d'));
        $this->assertEquals(1400.00, $membership->final_amount);
    }

    public function test_active_membership_renewal_extends_from_previous_expiry_date(): void
    {
        $library = Library::create(['name' => 'Lib A', 'slug' => 'a', 'email' => 'a@t.com', 'mobile' => '9999999999', 'status' => 'active']);
        $branch = Branch::create(['library_id' => $library->id, 'name' => 'B1', 'code' => 'B1', 'status' => 'active']);
        $student = Student::create(['library_id' => $library->id, 'student_number' => 'LIB-000001', 'first_name' => 'A', 'mobile' => '9800000000', 'status' => 'active', 'joined_at' => now()]);
        $plan = MembershipPlan::create(['library_id' => $library->id, 'name' => '30 Days Plan', 'duration_days' => 30, 'price' => 1500.00, 'status' => 'active']);

        // Existing membership active until 2026-10-31
        $existing = Membership::create([
            'library_id' => $library->id,
            'branch_id' => $branch->id,
            'student_id' => $student->id,
            'membership_plan_id' => $plan->id,
            'start_date' => '2026-10-02',
            'end_date' => '2026-10-31',
            'price' => 1500.00,
            'discount' => 0.00,
            'final_amount' => 1500.00,
            'status' => 'active',
        ]);

        $service = new MembershipService();
        $renewed = $service->renewMembership($existing, $plan->id, 0.00, 'Renewal Test');

        // New start date must be 2026-11-01 (day after 2026-10-31)
        $this->assertEquals('2026-11-01', $renewed->start_date->format('Y-m-d'));
        $this->assertEquals('2026-11-30', $renewed->end_date->format('Y-m-d'));
        $this->assertDatabaseCount('memberships', 2); // Non-destructive retention
    }
}
