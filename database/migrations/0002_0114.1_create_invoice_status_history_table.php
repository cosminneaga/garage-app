<?php

use App\Enums\Status\InvoiceStatus;
use App\Models\Invoice;
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
        Schema::create('invoice_status_history', function (Blueprint $table) {
            $table->id();

            $table->string('status')->default(InvoiceStatus::DRAFT->value);
            $table->string('description')->nullable();

            $table->foreignIdFor(Invoice::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_status_history');
    }
};
