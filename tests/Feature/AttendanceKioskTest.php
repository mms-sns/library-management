<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\IDCard;
use App\Models\Library;
use App\Models\Student;
use App\Models\User;
use App\Services\AttendanceService;
use App\Services\IDCardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AttendanceKioskTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Library $library;
    protected Branch $branch;
    protected Student $student;
    protected IDCard $idCard;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'library_owner']);
        Role::firstOrCreate(['name' => 'branch_manager']);

        $this->library = Library::create([
            'name' => 'Apex Test Library',
            'slug' => 'apex-test-library',
            'mobile' => '9876543210',
            'status' => 'active',
        ]);

        $this->branch = Branch::create([
            'library_id' => $this->library->id,
            'name' => 'Main Branch',
            'code' => 'MAIN-01',
            'status' => 'active',
        ]);

        $this->owner = User::factory()->create([
            'library_id' => $this->library->id,
        ]);
        $this->owner->assignRole('library_owner');

        $this->student = Student::create([
            'library_id' => $this->library->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Ananya',
            'last_name' => 'Gupta',
            'mobile' => '9988776655',
            'status' => 'active',
            'joining_date' => now()->toDateString(),
        ]);

        $idCardService = app(IDCardService::class);
        $this->idCard = $idCardService->issueCard($this->student, ['branch_id' => $this->branch->id]);
    }

    public function test_can_check_in_and_check_out_student(): void
    {
        $service = app(AttendanceService::class);

        // Perform Check-in
        $attendance = $service->checkIn($this->student, ['branch_id' => $this->branch->id]);
        $this->assertEquals('present', $attendance->status);
        $this->assertEquals($this->student->id, $attendance->student_id);

        // Perform Check-out
        $updated = $service->checkOut($attendance);
        $this->assertEquals('checked_out', $updated->status);
        $this->assertNotNull($updated->check_out_at);
    }

    public function test_kiosk_qr_scan_toggles_checkin_and_checkout(): void
    {
        $service = app(AttendanceService::class);

        // Scan 1: Should check IN
        $res1 = $service->processScan($this->idCard->qr_token, $this->branch->id);
        $this->assertTrue($res1['success']);
        $this->assertEquals('check_in', $res1['action']);
        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'status' => 'present',
        ]);

        // Scan 2: Should check OUT
        $res2 = $service->processScan($this->idCard->qr_token, $this->branch->id);
        $this->assertTrue($res2['success']);
        $this->assertEquals('check_out', $res2['action']);
        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'status' => 'checked_out',
        ]);
    }

    public function test_kiosk_scan_api_endpoint_returns_json(): void
    {
        $response = $this->actingAs($this->owner)->postJson(route('kiosk.scan'), [
            'token' => $this->idCard->qr_token,
            'branch_id' => $this->branch->id,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'action' => 'check_in',
        ]);
    }

    public function test_attendance_logs_view_accessible(): void
    {
        $response = $this->actingAs($this->owner)->get(route('attendances.index'));
        $response->assertStatus(200);
        $response->assertSee('Daily Attendance Logs');
    }
}
