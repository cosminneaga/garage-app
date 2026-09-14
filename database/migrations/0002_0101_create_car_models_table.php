<?php

use App\Models\CarMake;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('class');

            $table->foreignIdFor(CarMake::class, 'make_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->index('name', 'cmd_name_idx');
            $table->index('class', 'cmd_class_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropIndex('cmd_name_idx');
            $table->dropIndex('cmd_class_idx');
        });
        Schema::dropIfExists('car_models');
    }
};
