<?php

namespace Tests\Feature;

use App\Models\Library;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);
    }

    public function test_student_number_generation_is_sequential_per_library(): void
    {
        $library = Library::create([
            'name' => 'Test Library',
            'slug' => 'test-lib',
            'email' => 'test@lib.com',
            'mobile' => '9999999999',
            'status' => 'active',
        ]);

        $service = new StudentService();

        $num1 = $service->generateStudentNumber($library->id);
        $this->assertEquals('LIB-000001', $num1);

        Student::create([
            'library_id' => $library->id,
            'student_number' => $num1,
            'first_name' => 'Student1',
            'mobile' => '9800000001',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $num2 = $service->generateStudentNumber($library->id);
        $this->assertEquals('LIB-000002', $num2);
    }

    public function test_student_creation_and_tenant_isolation(): void
    {
        $libraryA = Library::create([
            'name' => 'Library Alpha',
            'slug' => 'lib-a',
            'email' => 'a@lib.com',
            'mobile' => '9999999991',
            'status' => 'active',
        ]);
        $ownerA = User::create([
            'library_id' => $libraryA->id,
            'name' => 'Owner Alpha',
            'email' => 'owner.a@lib.com',
            'password' => bcrypt('password'),
        ]);
        $ownerA->assignRole('library_owner');

        $studentA = Student::create([
            'library_id' => $libraryA->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Rahul',
            'last_name' => 'Sharma',
            'mobile' => '9810011111',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        $libraryB = Library::create([
            'name' => 'Library Beta',
            'slug' => 'lib-b',
            'email' => 'b@lib.com',
            'mobile' => '9999999992',
            'status' => 'active',
        ]);
        $studentB = Student::create([
            'library_id' => $libraryB->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Priya',
            'last_name' => 'Singh',
            'mobile' => '9810022222',
            'status' => 'active',
            'joined_at' => now(),
        ]);

        // Owner A lists students
        $response = $this->actingAs($ownerA)->get(route('students.index'));
        $response->assertStatus(200);
        $response->assertSee('Rahul');
        $response->assertDontSee('Priya');

        // Owner A attempts viewing Student B
        $viewResponse = $this->actingAs($ownerA)->get(route('students.show', $studentB));
        $viewResponse->assertStatus(403);
    }
}
