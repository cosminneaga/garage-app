<?php

use App\Models\Client;
use App\Models\Company;
use App\Models\VehicleMake;
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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('registration');
            $table->string('vin');
            $table->integer('odometer');
            $table->string('fuel')->default('other');
            $table->string('status')->default('reception');

            $table->text('complaint_description')->nullable();
            $table->text('initial_inspection')->nullable();
            $table->text('diagnostic')->nullable();
            $table->text('work_order')->nullable();
            $table->text('parts_required')->nullable();
            $table->text('execution_data')->nullable();
            $table->text('labour_tracking_data')->nullable();
            $table->text('quality_check_testing')->nullable();
            $table->text('service_record')->nullable();

            $table->foreignIdFor(VehicleMake::class)->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
