<?php

use App\Enums\WorkorderStatus;
use App\Models\Booking;
use App\Models\Company;
use App\Models\File;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workorders', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->integer('number')->unique('workorder_number');
            $table->string('status')->default(WorkorderStatus::PENDING->value);
            $table->integer('odometer_on_start')->nullable();
            $table->integer('odometer_on_finish')->nullable();
            $table->longText('complaint')->nullable();
            $table->longText('initial_inspection_notes')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('component_notes')->nullable();
            $table->decimal('parts_total_cost', 10, 2)->nullable();
            $table->decimal('labour_price_hourly', 10, 2)->nullable();
            $table->decimal('labour_total_cost', 10, 2)->nullable();

            $table->foreignIdFor(User::class, 'tehnician_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Booking::class, 'booking_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Company::class, 'company_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'assigned_by')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'initial_inspection_files')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(File::class, 'note_files')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Vehicle::class, 'vehicle_id')->constrained()->cascadeOnUpdate();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorders');
    }
};
