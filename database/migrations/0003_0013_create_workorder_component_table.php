<?php

use App\Models\Workorder;
use App\Models\WorkorderReplacedComponent;
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
        Schema::create('workorder_component', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workorder::class, 'workorder_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(WorkorderReplacedComponent::class, 'component_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_component');
    }
};
