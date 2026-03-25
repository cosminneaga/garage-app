<?php

use App\Models\Repair;
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
        Schema::create('repair_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable(false);
            $table->float('work_time', precision: 2)->nullable(false);
            $table->float('hourly_charge', precision: 2)->nullable(false);
            $table->string('status')->default('draft');
            $table->float('discount_applied', precision: 2)->default(0.00);
            $table->float('paid_amount', precision: 2)->default(0.00);
            $table->text('description')->nullable();

            $table->foreignIdFor(Repair::class)->constrained()->cascadeOnUpdate();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_invoices');
    }
};
