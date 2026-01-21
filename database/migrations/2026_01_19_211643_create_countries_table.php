<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            // Identifiers
            $table->string('iso_alpha2', 2)->unique();
            $table->string('iso_alpha3', 3)->unique(); // Used for border mapping

            // Names (used for search)
            $table->string('common_name')->index();
            $table->string('official_name');

            // Attributes
            $table->unsignedBigInteger('population');
            $table->string('region')->index(); // Indexed for filtering
            $table->string('sub_region')->nullable()->index();
            $table->string('capital')->nullable()->index(); // Indexed for search

            // Metadata
            $table->string('top_level_domain')->nullable();
            $table->json('currencies')->nullable();
            $table->json('languages')->nullable();
            $table->string('flag_url')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('countries'); }
};
