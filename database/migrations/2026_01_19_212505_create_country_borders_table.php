<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('country_borders', function (Blueprint $table) {
            $table->id();

            // The country that HAS the border
            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            // The country THAT IS the border
            $table->foreignId('border_country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            // Prevent duplicate border rows (e.g. France-Spain twice)
            $table->unique(['country_id', 'border_country_id']);

            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('country_borders'); }
};
