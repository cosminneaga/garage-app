<?php

use App\Models\Country;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('street_number', length: 30)->nullable(false);
            $table->string('street', length: 150)->nullable(false);
            $table->string('postcode', length: 20)->nullable(false);
            $table->string('building', 50)->nullable();
            $table->string('floor', 20)->nullable();
            $table->string('unit', 20)->nullable();
            $geo = $table->geography('coordinates', subtype: 'point', srid: 4326);

            if (Schema::getConnection()->getDriverName() === 'sqlite') {
                $geo->nullable();
            } else {
                $table->spatialIndex('coordinates');
            }

            $table->foreignIdFor(Country::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
