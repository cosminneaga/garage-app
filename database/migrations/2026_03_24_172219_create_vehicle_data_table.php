<?php

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cylinders');
            $table->float('displacement', precision: 1);
            $table->string('drive');
            $table->string('transmission');
            $table->foreignIdFor(VehicleMake::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(VehicleModel::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(VehicleYear::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_data');
    }
};
