<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Invoice;
use App\Models\Library;
use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use App\Services\InvoiceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FinancialManagementTest extends TestCase
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
            'branch_id' => $this->branch->id,
            'student_number' => 'LIB-000001',
            'first_name' => 'Rahul',
            'last_name' => 'Sharma',
            'mobile' => '9988776655',
            'status' => 'active',
            'joining_date' => now()->toDateString(),
        ]);
    }

    public function test_can_create_invoice_with_line_items_and_sequential_numbering(): void
    {
        $service = app(InvoiceService::class);

        $invoice = $service->createInvoice([
            'library_id' => $this->library->id,
            'branch_id' => $this->branch->id,
            'student_id' => $this->student->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'discount' => 100.00,
            'tax' => 180.00,
        ], [
            ['description' => 'Monthly Fee', 'quantity' => 1, 'unit_price' => 1000.00],
        ]);

        $this->assertEquals('INV-000001', $invoice->invoice_number);
        $this->assertEquals(1000.00, $invoice->subtotal);
        $this->assertEquals(1080.00, $invoice->total); // 1000 - 100 + 180 = 1080
        $this->assertEquals(1080.00, $invoice->balance_amount);
        $this->assertEquals('issued', $invoice->status);
        $this->assertCount(1, $invoice->items);
    }

    public function test_can_record_partial_and_full_payments(): void
    {
        $service = app(InvoiceService::class);

        $invoice = $service->createInvoice([
            'library_id' => $this->library->id,
            'branch_id' => $this->branch->id,
            'student_id' => $this->student->id,
            'invoice_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'discount' => 0.00,
            'tax' => 0.00,
        ], [
            ['description' => 'Quarterly Plan', 'quantity' => 1, 'unit_price' => 3000.00],
        ]);

        // Record Partial Payment of 1000
        $payment1 = $service->recordPayment($invoice, [
            'amount' => 1000.00,
            'payment_method' => 'cash',
            'payment_date' => now()->toDateTimeString(),
            'received_by' => $this->owner->id,
        ]);

        $invoice->refresh();
        $this->assertEquals('PAY-000001', $payment1->payment_number);
        $this->assertEquals(1000.00, $invoice->paid_amount);
        $this->assertEquals(2000.00, $invoice->balance_amount);
        $this->assertEquals('partially_paid', $invoice->status);

        // Record Remaining Payment of 2000
        $payment2 = $service->recordPayment($invoice, [
            'amount' => 2000.00,
            'payment_method' => 'upi',
            'transaction_reference' => 'UPI/12345678',
            'payment_date' => now()->toDateTimeString(),
            'received_by' => $this->owner->id,
        ]);

        $invoice->refresh();
        $this->assertEquals('PAY-000002', $payment2->payment_number);
        $this->assertEquals(3000.00, $invoice->paid_amount);
        $this->assertEquals(0.00, $invoice->balance_amount);
        $this->assertEquals('paid', $invoice->status);
    }

    public function test_invoice_index_page_accessible(): void
    {
        $response = $this->actingAs($this->owner)->get(route('invoices.index'));
        $response->assertStatus(200);
        $response->assertSee('Fee Invoices');
    }

    public function test_payments_index_page_accessible(): void
    {
        $response = $this->actingAs($this->owner)->get(route('payments.index'));
        $response->assertStatus(200);
        $response->assertSee('Payment Receipts');
    }
}
