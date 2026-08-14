<?php

use App\Enums\BookingStatus;
use App\Enums\Priority;
use App\Enums\ServiceType;
use App\Models\Client;
use App\Models\Company;
use App\Models\User;
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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('status')->default(BookingStatus::PENDING->value);
            $table->string('service_type')->default(ServiceType::SERVICE->value);
            $table->string('priority')->default(Priority::LOW->value);
            $table->dateTime('appointment_start')->nullable();
            $table->dateTime('appointment_finish')->nullable();
            $table->dateTime('reminder_sent_at')->nullable();
            $table->dateTime('checked_in_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('cancelled_at')->nullable();
            $table->integer('estimated_duration')->nullable();
            $table->text('status_info')->nullable();
            $table->longText('complaint')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('client_notes')->nullable();
            $table->decimal('estimated_cost', 10, 2)->nullable();

            $table->foreignIdFor(Client::class, 'client_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Vehicle::class, 'vehicle_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Company::class, 'company_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'advisor_id')->constrained()->cascadeOnUpdate();

            $table->auditColumns();

            $table->index('number', 'bk_number_idx');
            $table->index('service_type', 'bk_servicetype_idx');
            $table->index('priority', 'bk_priority_idx');
            $table->index('appointment_start', 'bk_appointmentstart_idx');
            $table->index('checked_in_at', 'bk_checkedinat_idx');
            $table->index('completed_at', 'bk_completedat_idx');
            $table->index('cancelled_at', 'bk_cancelledat_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex('bk_number_idx');
            $table->dropIndex('bk_servicetype_idx');
            $table->dropIndex('bk_priority_idx');
            $table->dropIndex('bk_appointmentstart_idx');
            $table->dropIndex('bk_checkedinat_idx');
            $table->dropIndex('bk_completedat_idx');
            $table->dropIndex('bk_cancelledat_idx');
        });

        Schema::dropIfExists('bookings');
    }
};
