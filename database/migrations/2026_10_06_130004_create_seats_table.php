<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('floor_id')->nullable()->constrained('floors')->nullOnDelete();
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->foreignId('seat_type_id')->constrained('seat_types')->restrictOnDelete();
            $table->string('seat_number', 50);
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance', 'inactive'])->default('available');
            $table->integer('position_x')->nullable();
            $table->integer('position_y')->nullable();
            $table->json('metadata')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['branch_id', 'seat_number']);
            $table->index('branch_id');
            $table->index('floor_id');
            $table->index('room_id');
            $table->index('seat_type_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
