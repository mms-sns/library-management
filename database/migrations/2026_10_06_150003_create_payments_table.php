<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')->constrained('libraries')->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained('branches')->restrictOnDelete();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->foreignId('invoice_id')->constrained('invoices')->restrictOnDelete();
            $table->string('payment_number', 100);
            $table->decimal('amount', 12, 2);
            $table->enum('payment_method', ['cash', 'upi', 'bank_transfer', 'card', 'gateway', 'other'])->default('cash');
            $table->string('transaction_reference', 255)->nullable();
            $table->dateTime('payment_date');
            $table->enum('status', ['completed', 'reversed', 'refunded'])->default('completed');
            $table->text('notes')->nullable();
            $table->foreignId('received_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->unique(['library_id', 'payment_number']);
            $table->index('library_id');
            $table->index('branch_id');
            $table->index('student_id');
            $table->index('invoice_id');
            $table->index('payment_method');
            $table->index('payment_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
