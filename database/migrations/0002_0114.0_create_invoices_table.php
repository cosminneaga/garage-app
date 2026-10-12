<?php

use App\Enums\PaymentMethod;
use App\Enums\Status\InvoiceStatus;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Company;
use App\Models\Vehicle;
use App\Models\Workorder;
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
            $table->string('number')->nullable();
            $table->string('status')->default(InvoiceStatus::DRAFT->value);

            # Totals
            $table->decimal('subtotal', 10, 2)->default(0.00);      # total before tax & discount
            $table->decimal('discount', 4, 2)->default(0.00);       # interface manageable
            $table->decimal('tax_amount', 10, 2)->default(0.00);    # editable + taken from company
            $table->decimal('total', 10, 2)->default(0.00);         # total after tax + discount
            $table->integer('worked_minutes')->default(0);          # operations sum of minutes
            $table->decimal('amount_due', 10, 2)->default(0.00);    # calculated after payment
            $table->decimal('amount_paid', 10, 2)->default(0.00);   # calculated on payment
            $table->string('payment_method')->default(PaymentMethod::OTHER->value);

            # Dates
            $table->dateTime('due_date')->nullable();
            $table->dateTime('paid_at')->nullable();                # set on payment
            $table->dateTime('issued_at')->nullable();              # set on notification sent
            $table->dateTime('cancelled_at')->nullable();

            # Details
            $table->longText('notes')->nullable();

            # Relations + Many to Many relation to InvoiceItem
            $table->foreignIdFor(Company::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Vehicle::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Booking::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Workorder::class)->nullable()->constrained()->cascadeOnDelete();

            # Audit
            $table->auditColumns();

            # Indexes
            $table->index('number', 'inv_number_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('inv_number_idx');
        });

        Schema::dropIfExists('invoices');
    }
};
