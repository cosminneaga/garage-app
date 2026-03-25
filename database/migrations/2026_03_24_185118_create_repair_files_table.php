<?php

use App\Models\Repair;
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
        Schema::create('repair_files', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->string('name')->nullable(false);
            $table->string('path')->nullable(false);
            $table->string('type')->nullable(false);
            $table->string('status')->default('before');
            $table->string('repair_status')->default('reception');

            $table->foreignIdFor(Repair::class)->constrained()->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_files');
    }
};
