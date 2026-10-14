<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $indexes = collect(Schema::getIndexes('id_cards'))->pluck('name');

        Schema::table('id_cards', function (Blueprint $table) use ($indexes) {
            if ($indexes->contains('id_cards_card_number_unique')) {
                $table->dropUnique('id_cards_card_number_unique');
            }

            if (!$indexes->contains('id_cards_library_id_card_number_unique')) {
                $table->unique(['library_id', 'card_number']);
            }
        });
    }

    public function down(): void
    {
        $indexes = collect(Schema::getIndexes('id_cards'))->pluck('name');

        Schema::table('id_cards', function (Blueprint $table) use ($indexes) {
            if ($indexes->contains('id_cards_library_id_card_number_unique')) {
                $table->dropUnique(['library_id', 'card_number']);
            }

            if (!$indexes->contains('id_cards_card_number_unique')) {
                $table->unique('card_number');
            }
        });
    }
};
