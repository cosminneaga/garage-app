<?php

use App\Models\Client;
use App\Models\Company;
use App\Models\Supplier;
use App\Models\User;
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
            $table->string('number', length: 30)->nullable(false);
            $table->string('name', length: 150)->nullable(false);
            $table->string('postcode', length: 20)->nullable(false);
            $table->string('building', 50)->nullable();
            $table->string('floor', 20)->nullable();
            $table->string('unit', 20)->nullable();
            $geo = $table->geography('coordinates', subtype: 'point', srid: 4326)->nullable();

            // if (Schema::getConnection()->getDriverName() === 'sqlite') {
            //     $geo->nullable();
            // } else {
            //     $table->spatialIndex('coordinates');
            // }

            # relations
            $table->foreignIdFor(Company::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Client::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Supplier::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->nullable()->constrained()->cascadeOnDelete();

            # world relations
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

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
