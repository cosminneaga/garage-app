<?php

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
        Schema::create('workorder_replaced_components', function (Blueprint $table) {
            $table->id();
            $table->longText('notes')->nullable();
            $table->dateTime('installed_at')->nullable();
            $table->integer('installed_odometer')->nullable();
            $table->integer('expected_life_km')->nullable();
            $table->integer('expected_life_months')->nullable();

            $table->foreignIdFor(Workorder::class, 'workorder_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Part::class, 'part_id')->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'replaced_by')->constrained()->cascadeOnDelete();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_replaced_components');
    }
};
