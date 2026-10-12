<?php

use App\Enums\Type\WorkorderOperationType;
use App\Models\InvoiceItem;
use App\Models\Part;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        # Invoice Line Items are actual pointing to Operations
        Schema::create('invoice_line_items', function (Blueprint $table) {
            $table->id();

            # Details
            $table->string('type')->default(WorkorderOperationType::OTHER->value);              # operation type
            $table->integer('worked_minutes')->default(0);                                      # sum of minutes worked in operation
            $table->foreignIdFor(Part::class)->nullable()->constrained()->cascadeOnDelete();    # the part replaced on vehicle

            # Totals
            $table->decimal('total_cost', 10, 2)->default(0.00);                                # (wo's labour_rate * total operation hours) + part_price

            # Relations
            $table->foreignIdFor(InvoiceItem::class)->constrained()->cascadeOnDelete();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_line_items');
    }
};
