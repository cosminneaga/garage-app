<?php

use App\Models\File;
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
        Schema::create('workorder_operation_file', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(WorkorderOperation::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(File::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workorder_operation_file');
    }
};
