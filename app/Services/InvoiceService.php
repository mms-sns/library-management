<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\LibrarySetting;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    /**
     * Generate sequential invoice number (e.g. INV-000001)
     */
    public function generateInvoiceNumber(int $libraryId): string
    {
        return DB::transaction(function () use ($libraryId) {
            $lastInvoice = Invoice::where('library_id', $libraryId)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($lastInvoice && preg_match('/INV-(\d+)/i', $lastInvoice->invoice_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            return sprintf('INV-%06d', $nextNumber);
        });
    }

    /**
     * Generate sequential payment reference (e.g. PAY-000001)
     */
    public function generatePaymentNumber(int $libraryId): string
    {
        return DB::transaction(function () use ($libraryId) {
            $lastPayment = Payment::where('library_id', $libraryId)
                ->orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            $nextNumber = 1;
            if ($lastPayment && preg_match('/PAY-(\d+)/i', $lastPayment->payment_number, $matches)) {
                $nextNumber = intval($matches[1]) + 1;
            }

            return sprintf('PAY-%06d', $nextNumber);
        });
    }

    /**
     * Create an invoice with items and GST calculation
     */
    public function createInvoice(array $data, array $items): Invoice
    {
        return DB::transaction(function () use ($data, $items) {
            $libraryId = $data['library_id'];

            if (empty($data['invoice_number'])) {
                $data['invoice_number'] = $this->generateInvoiceNumber($libraryId);
            }

            // Calculate subtotal from items
            $subtotal = 0.00;
            foreach ($items as $item) {
                $subtotal += ($item['quantity'] * $item['unit_price']);
            }

            $discount = floatval($data['discount'] ?? 0.00);

            // Compute GST if enabled in Library Settings
            $settings = LibrarySetting::where('library_id', $libraryId)->first();
            $taxRate = ($settings && $settings->gst_enabled) ? floatval($settings->tax_rate) : 0.00;

            $taxableAmount = max(0, $subtotal - $discount);
            $tax = round(($taxableAmount * $taxRate) / 100, 2);

            $total = $taxableAmount + $tax;
            $paidAmount = floatval($data['paid_amount'] ?? 0.00);
            $balanceAmount = max(0, $total - $paidAmount);

            $status = $data['status'] ?? ($paidAmount >= $total ? 'paid' : ($paidAmount > 0 ? 'partially_paid' : 'issued'));

            $invoice = Invoice::create([
                'library_id' => $libraryId,
                'branch_id' => $data['branch_id'],
                'student_id' => $data['student_id'],
                'membership_id' => $data['membership_id'] ?? null,
                'invoice_number' => $data['invoice_number'],
                'invoice_date' => $data['invoice_date'] ?? now()->format('Y-m-d'),
                'due_date' => $data['due_date'] ?? now()->addDays(7)->format('Y-m-d'),
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'balance_amount' => $balanceAmount,
                'status' => $status,
                'notes' => $data['notes'] ?? null,
            ]);

            // Save line items
            foreach ($items as $item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'amount' => $item['quantity'] * $item['unit_price'],
                ]);
            }

            // If initial paid amount was supplied, record first payment transaction
            if ($paidAmount > 0 && !empty($data['payment_method'])) {
                $paymentNumber = $this->generatePaymentNumber($libraryId);

                Payment::create([
                    'library_id' => $libraryId,
                    'branch_id' => $invoice->branch_id,
                    'student_id' => $invoice->student_id,
                    'invoice_id' => $invoice->id,
                    'payment_number' => $paymentNumber,
                    'amount' => $paidAmount,
                    'payment_method' => $data['payment_method'],
                    'transaction_reference' => $data['transaction_reference'] ?? null,
                    'payment_date' => now(),
                    'status' => 'completed',
                    'notes' => 'Initial payment upon invoice creation',
                    'received_by' => $data['received_by'],
                ]);
            }

            return $invoice;
        });
    }

    /**
     * Record a payment against an existing invoice
     */
    public function recordPayment(Invoice $invoice, array $paymentData): Payment
    {
        return DB::transaction(function () use ($invoice, $paymentData) {
            $amount = floatval($paymentData['amount']);
            $paymentNumber = $this->generatePaymentNumber($invoice->library_id);

            $payment = Payment::create([
                'library_id' => $invoice->library_id,
                'branch_id' => $invoice->branch_id,
                'student_id' => $invoice->student_id,
                'invoice_id' => $invoice->id,
                'payment_number' => $paymentNumber,
                'amount' => $amount,
                'payment_method' => $paymentData['payment_method'],
                'transaction_reference' => $paymentData['transaction_reference'] ?? null,
                'payment_date' => $paymentData['payment_date'] ?? now(),
                'status' => 'completed',
                'notes' => $paymentData['notes'] ?? null,
                'received_by' => $paymentData['received_by'],
            ]);

            // Update Invoice paid & balance amounts
            $newPaidAmount = $invoice->paid_amount + $amount;
            $newBalance = max(0, $invoice->total - $newPaidAmount);
            $newStatus = $newBalance <= 0 ? 'paid' : 'partially_paid';

            $invoice->update([
                'paid_amount' => $newPaidAmount,
                'balance_amount' => $newBalance,
                'status' => $newStatus,
            ]);

            return $payment;
        });
    }
}
