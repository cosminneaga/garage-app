<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_makes', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->timestamps();

            $table->index('name', 'cmk_name_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_makes', function (Blueprint $table) {
            $table->dropIndex('cmk_name_idx');
        });

        Schema::dropIfExists('car_makes');
    }
};
