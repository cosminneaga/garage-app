<?php

use App\Models\VehicleMake;
use App\Models\VehicleModel;
use App\Models\VehicleYear;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cylinders');
            $table->decimal('displacement', 3, 1);
            $table->string('drive');
            $table->string('transmission');

            $table->foreignIdFor(VehicleMake::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(VehicleModel::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(VehicleYear::class)->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->index('name', 'vhd_name_idx');
            $table->index('cylinders', 'vhd_cylinders_idx');
            $table->index('displacement', 'vhd_displacement_idx');
            $table->index('drive', 'vhd_drive_idx');
            $table->index('transmission', 'vhd_transmission_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_data', function (Blueprint $table) {
            $table->dropIndex('vhd_name_idx');
            $table->dropIndex('vhd_cylinders_idx');
            $table->dropIndex('vhd_displacement_idx');
            $table->dropIndex('vhd_drive_idx');
            $table->dropIndex('vhd_transmission_idx');
        });

        Schema::dropIfExists('vehicle_data');
    }
};
