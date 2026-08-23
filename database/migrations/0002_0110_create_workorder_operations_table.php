<?php

use App\Enums\WorkorderOperationType;
use App\Models\Part;
use App\Models\User;
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
        Schema::create('workorder_operations', function (Blueprint $table) {
            $table->id();

            $table->string('type')->default(WorkorderOperationType::REPAIR->value);
            $table->integer('part_installed_odometer')->nullable();
            $table->integer('expected_life_km')->nullable();
            $table->integer('expected_life_months')->nullable();
            $table->longText('notes')->nullable();

            $table->foreignIdFor(Workorder::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Part::class)->nullable()->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'performed_by')->constrained()->cascadeOnDelete();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_operations');
    }
};
