<?php

use App\Models\Repair;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable(false);
            $table->decimal('work_time', 8, 2)->default(0.00);
            $table->decimal('hourly_charge', 8, 2)->default(0.00);
            $table->string('status')->default('draft');
            $table->decimal('discount_applied', 4, 2)->default(0.00);
            $table->decimal('paid_amount', 4, 2)->default(0.00);
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
        Schema::dropIfExists('invoices');
    }
};
