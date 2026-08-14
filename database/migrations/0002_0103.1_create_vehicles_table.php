<?php

use App\Enums\FuelType;
use App\Enums\VehicleStatus;
use App\Models\VehicleData;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vin')->unique();
            $table->string('registration')->nullable();
            $table->string('fuel')->default(FuelType::OTHER->value);
            $table->string('status')->default(VehicleStatus::ACTIVE->value);
            $table->integer('first_visit_odometer')->nullable();
            $table->dateTime('first_registration')->nullable();
            $table->dateTime('first_visit')->nullable();
            $table->longText('technical_notes')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('diagnostic_information')->nullable();

            $table->foreignIdFor(VehicleMake::class)->nullable();
            $table->foreignIdFor(VehicleModel::class)->nullable();
            $table->foreignIdFor(VehicleData::class)->nullable();
            $table->foreignIdFor(VehicleYear::class)->nullable();

            $table->auditColumns();

            $table->index('vin', 'vh_vin_idx');
            $table->index('registration', 'vh_registration_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex('vh_vin_idx');
            $table->dropIndex('vh_registration_idx');
        });

        Schema::dropIfExists('vehicles');
    }
};
