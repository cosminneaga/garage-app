<?php

use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('status')->default(InvoiceStatus::DRAFT->value);
            $table->dateTime('due_date')->nullable();               # set on creation
            $table->dateTime('paid_at')->nullable();                # set on payment
            $table->dateTime('sent_at')->nullable();                # set on notification sent

            # Totals
            $table->decimal('subtotal', 10, 2)->default(0.00);      # total before tax & discount
            $table->decimal('discount', 4, 2)->default(0.00);       # interface manageable
            $table->decimal('tax_amount', 10, 2)->default(0.00);    # editable + taken from company
            $table->decimal('total', 10, 2)->default(0.00);         # total after tax + discount
            $table->integer('worked_minutes')->default(0);          # operations sum of minutes
            $table->decimal('amount_due', 10, 2)->default(0.00);    # calculated after payment
            $table->decimal('amount_paid', 10, 2)->default(0.00);   # calculated on payment
            $table->string('payment_method')->default(PaymentMethod::OTHER->value);

            # Details
            $table->longText('notes')->nullable();

            # Relations + Many to Many relation to InvoiceItem
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Vehicle::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Booking::class)->nullable()->constrained()->cascadeOnDelete();

            # Audit
            $table->auditColumns();
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
