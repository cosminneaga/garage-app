<?php

use App\Models\RepairInvoice;
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
        Schema::create('repair_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->integer('quantity')->default(0);
            $table->decimal('item_price', 8, 2)->default(0.00);
            $table->decimal('labour_price', 8, 2)->default(0.00);

            $table->foreignIdFor(RepairInvoice::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_invoice_items');
    }
};
