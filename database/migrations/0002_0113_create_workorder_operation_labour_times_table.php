<?php

use App\Models\WorkorderOperation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workorder_operation_labour_times', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();

            $table->foreignIdFor(WorkorderOperation::class)->constrained()->cascadeOnDelete();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_operation_labour_times');
    }
};
