<?php

use App\Models\VehicleMake;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('manufacturer')->nullable();
            $table->string('part_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('code')->nullable();
            $table->longText('notes')->nullable();

            $table->foreignIdFor(VehicleMake::class, 'brand')->constrained()->cascadeOnDelete();

            $table->auditColumns();

            $table->index('name', 'pt_name_idx');
            $table->index('manufacturer', 'pt_manufacturer_idx');
            $table->index('part_number', 'pt_partnumber_idx');
            $table->index('serial_number', 'pt_serialnumber_idx');
            $table->index('code', 'pt_code_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parts', function (Blueprint $table) {
            $table->dropIndex('pt_name_idx');
            $table->dropIndex('pt_manufacturer_idx');
            $table->dropIndex('pt_partnumber_idx');
            $table->dropIndex('pt_serialnumber_idx');
            $table->dropIndex('pt_code_idx');
        });

        Schema::dropIfExists('parts');
    }
};
