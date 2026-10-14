<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')->constrained('libraries')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('student_number', 50);
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('photo', 255)->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->default('male');
            $table->date('date_of_birth')->nullable();
            $table->string('mobile', 20);
            $table->string('email', 255)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('pincode', 10)->nullable();
            $table->enum('status', ['active', 'inactive', 'suspended', 'blacklisted'])->default('active');
            $table->date('joined_at');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['library_id', 'student_number']);
            $table->index('mobile');
            $table->index('status');
            $table->index('joined_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
