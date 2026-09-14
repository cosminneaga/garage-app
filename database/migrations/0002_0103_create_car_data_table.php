<?php

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('cylinders');
            $table->decimal('displacement', 3, 1);
            $table->string('drive');
            $table->string('transmission');

            $table->foreignIdFor(CarMake::class, 'make_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(CarModel::class, 'model_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            $table->index('name', 'cdt_name_idx');
            $table->index('cylinders', 'cdt_cylinders_idx');
            $table->index('displacement', 'cdt_displacement_idx');
            $table->index('drive', 'cdt_drive_idx');
            $table->index('transmission', 'cdt_transmission_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_data', function (Blueprint $table) {
            $table->dropIndex('cdt_name_idx');
            $table->dropIndex('cdt_cylinders_idx');
            $table->dropIndex('cdt_displacement_idx');
            $table->dropIndex('cdt_drive_idx');
            $table->dropIndex('cdt_transmission_idx');
        });

        Schema::dropIfExists('car_data');
    }
};
