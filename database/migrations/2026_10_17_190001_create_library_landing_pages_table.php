<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_landing_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')->constrained('libraries')->cascadeOnDelete();
            $table->boolean('is_enabled')->default(false);
            $table->string('hero_title')->nullable();
            $table->text('hero_tagline')->nullable();
            $table->string('announcement')->nullable();
            $table->string('about_title')->nullable();
            $table->text('about_text')->nullable();
            $table->json('amenities')->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->string('contact_email', 150)->nullable();
            $table->string('whatsapp_number', 30)->nullable();
            $table->text('address')->nullable();
            $table->text('google_maps_url')->nullable();
            $table->boolean('show_pricing')->default(true);
            $table->boolean('show_timing')->default(true);
            $table->boolean('show_seats_status')->default(true);
            $table->string('seo_meta_title')->nullable();
            $table->text('seo_meta_description')->nullable();
            $table->timestamps();

            $table->unique('library_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_landing_pages');
    }
};
