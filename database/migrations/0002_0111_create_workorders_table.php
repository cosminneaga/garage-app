<?php

use App\Enums\WorkorderStatus;
use App\Models\Booking;
use App\Models\User;
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
            $table->string('number')->nullable();
            $table->string('status')->default(WorkorderStatus::PENDING->value);
            $table->integer('odometer_on_start')->nullable();
            $table->integer('odometer_on_finish')->nullable();
            $table->longText('complaint')->nullable();
            $table->longText('initial_inspection_notes')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('part_notes')->nullable();
            $table->decimal('labour_price_hourly', 10, 2)->default(0.00);
            $table->decimal('labour_total_cost', 10, 2)->default(0.00);
            $table->decimal('part_total_cost', 10, 2)->default(0.00);

            $table->foreignIdFor(Booking::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'technician_id')->constrained()->cascadeOnDelete();

            $table->auditColumns();

            $table->index('title', 'wo_title_idx');
            $table->index('number', 'wo_number_idx');
            $table->index('status', 'wo_status_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workorders', function (Blueprint $table) {
            $table->dropIndex('wo_title_idx');
            $table->dropIndex('wo_number_idx');
            $table->dropIndex('wo_status_idx');
        });

        Schema::dropIfExists('workorders');
    }
};
