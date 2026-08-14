<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking_status_history', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default(BookingStatus::PENDING->value);
            $table->longText('notes')->nullable();

            $table->foreignIdFor(Booking::class, 'booking_id')->constrained()->cascadeOnUpdate();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_status_history');
    }
};
