<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/xxxx_xx_xx_create_country_views_table.php

return new class extends Migration {
    public function up(): void
    {
        Schema::create('country_views', function (Blueprint $table) {
            $table->id();

            // Links to the country being viewed
            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();
            $table->index(['country_id', 'created_at']);

            // We use timestamps to calculate the "Last 24 Hours" trending logic
            $table->timestamps();
        });
    }

    public function down(): void { Schema::dropIfExists('country_views'); }
};
