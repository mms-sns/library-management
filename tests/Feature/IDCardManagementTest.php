<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\IDCard;
use App\Models\Library;
use App\Models\Student;
use App\Models\User;
use App\Services\IDCardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IDCardManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $owner;
    protected Library $library;
    protected Branch $branch;
    protected Student $student;

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
            'first_name' => 'Vikram',
            'last_name' => 'Singh',
            'mobile' => '9988776655',
            'status' => 'active',
            'joining_date' => now()->toDateString(),
        ]);
    }

    public function test_can_issue_id_card_with_sequential_number_and_qr_token(): void
    {
        $service = app(IDCardService::class);

        $card = $service->issueCard($this->student, [
            'issue_date' => now()->toDateString(),
            'expiry_date' => now()->addYear()->toDateString(),
        ]);

        $this->assertEquals('IDC-000001', $card->card_number);
        $this->assertNotNull($card->qr_token);
        $this->assertEquals(40, strlen($card->qr_token));
        $this->assertEquals('active', $card->status);
        $this->assertEquals($this->student->id, $card->student_id);
    }

    public function test_issuing_new_card_deactivates_previous_active_card(): void
    {
        $service = app(IDCardService::class);

        $card1 = $service->issueCard($this->student);
        $this->assertEquals('active', $card1->status);

        $card2 = $service->issueCard($this->student);

        $card1->refresh();
        $this->assertEquals('expired', $card1->status);
        $this->assertEquals('active', $card2->status);
        $this->assertEquals('IDC-000002', $card2->card_number);
    }

    public function test_can_revoke_id_card(): void
    {
        $service = app(IDCardService::class);
        $card = $service->issueCard($this->student);

        $service->revokeCard($card, 'Card lost by student');

        $card->refresh();
        $this->assertEquals('revoked', $card->status);
        $this->assertStringContainsString('Revoked: Card lost by student', $card->notes);
    }

    public function test_id_cards_index_and_badge_show_accessible(): void
    {
        $service = app(IDCardService::class);
        $card = $service->issueCard($this->student);

        $responseIndex = $this->actingAs($this->owner)->get(route('id-cards.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('IDC-000001');

        $responseShow = $this->actingAs($this->owner)->get(route('id-cards.show', $card));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Vikram Singh');

        $responseBatch = $this->actingAs($this->owner)->get(route('id-cards.batch-print'));
        $responseBatch->assertStatus(200);
        $responseBatch->assertSee('Batch Print ID Cards Sheet');
    }

    public function test_id_card_numbers_are_scoped_per_library(): void
    {
        $service = app(IDCardService::class);

        $secondLibrary = Library::create([
            'name' => 'Metro Digital Library',
            'slug' => 'metro-digital-library',
            'mobile' => '9123456780',
            'status' => 'active',
        ]);

        $secondBranch = Branch::create([
            'library_id' => $secondLibrary->id,
            'name' => 'City Branch',
            'code' => 'CITY-01',
            'status' => 'active',
        ]);

        $secondStudent = Student::create([
            'library_id' => $secondLibrary->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Rahul',
            'last_name' => 'Verma',
            'mobile' => '9871234567',
            'status' => 'active',
            'joining_date' => now()->toDateString(),
        ]);

        $cardLib1 = $service->issueCard($this->student);
        $cardLib2 = $service->issueCard($secondStudent, ['branch_id' => $secondBranch->id]);

        $this->assertEquals('IDC-000001', $cardLib1->card_number);
        $this->assertEquals('IDC-000001', $cardLib2->card_number);
        $this->assertNotEquals($cardLib1->library_id, $cardLib2->library_id);
        $this->assertNotEquals($cardLib1->qr_token, $cardLib2->qr_token);
    }
}
