<?php

use App\Models\VehicleMake;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('class');

            $table->foreignIdFor(VehicleMake::class)->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->index('name', 'vhmd_name_idx');
            $table->index('class', 'vhmd_class_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->dropIndex('vhmd_name_idx');
            $table->dropIndex('vhmd_class_idx');
        });
        Schema::dropIfExists('vehicle_models');
    }
};
