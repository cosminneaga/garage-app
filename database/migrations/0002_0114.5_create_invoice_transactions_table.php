<?php

use App\Enums\PaymentMethod;
use App\Enums\Type\TransactionType;
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
        Schema::create('invoice_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('method')->default(PaymentMethod::OTHER->value);
            $table->string('type')->default(TransactionType::PAYMENT->value);
            $table->decimal('value', 10, 2)->default(0.00);

            $table->foreignIdFor(Invoice::class)->constrained()->cascadeOnDelete();

            $table->auditColumns();

            # Indexes
            $table->index('method', 'inv_trns_method_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_transactions', function (Blueprint $table) {
            $table->dropIndex('inv_trns_method_idx');
        });

        Schema::dropIfExists('invoice_transactions');
    }
};
