<?php

use App\Models\Workorder;
use App\Models\WorkorderLabourTime;
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
        Schema::create('workorder_time', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workorder::class, 'workorder_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(WorkorderLabourTime::class, 'time_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_time');
    }
};
