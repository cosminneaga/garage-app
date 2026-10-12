<?php

use App\Enums\JobName;
use App\Models\Invoice;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        # Invoice items are actual pointing to a Workorder
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();

            # Details
            $table->string('job_name')->default(JobName::OIL_CHANGE->value);    # wo title
            $table->string('workorder_number');                                 # wo number
            $table->integer('odometer_on_start')->nullable();                   # wo odometer_on_start
            $table->integer('odometer_on_finish')->nullable();                  # wo odometer_on_finish

            # Totals sum of operations
            $table->integer('worked_minutes')->default(0);                      # sum of minutes

            # Totals of workorder
            $table->decimal('labour_rate', 10, 2)->default(0.00);               # wo entitle labour_rate
            $table->decimal('total_cost', 10, 2)->default(0.00);                # sum labour_total_cost, part_total_cost

            # Relations
            $table->foreignIdFor(Invoice::class)->constrained()->cascadeOnDelete();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
