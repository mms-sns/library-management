<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')->constrained('libraries')->cascadeOnDelete();
            $table->string('timezone', 50)->default('Asia/Kolkata');
            $table->string('currency', 10)->default('INR');
            $table->string('date_format', 20)->default('DD-MM-YYYY');
            $table->string('time_format', 20)->default('12h');
            $table->time('opening_time')->default('06:00:00');
            $table->time('closing_time')->default('23:00:00');
            $table->integer('duplicate_scan_delay_seconds')->default(60);
            $table->integer('grace_period_days')->default(0);
            $table->boolean('gst_enabled')->default(false);
            $table->string('gst_number', 50)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->timestamps();

            $table->unique('library_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_settings');
    }
};
