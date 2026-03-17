<?php

use App\Models\Country;
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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 40)->comment('Full name.');
            $table->string('email', length: 30)->comment('Email address.');
            $table->boolean('active')->comment('Account status.');
            $table->string('password')->nullable(false);
            $table->string('access_token')->nullable()->comment('The customer access token used to access API resources.');
            $table->string('street', length: 50)->nullable(false)->comment('Street name');
            $table->string('number', length: 5)->nullable(false)->comment('Location number');
            $table->string('address_extrainfo')->nullable()->comment('Address extra information');
            $table->foreignIdFor(Country::class)->constrained()->nullable(false);
            $table->string('postcode', length: 10)->nullable(false);
            $table->string('mobile', length: 20);
            $table->string('landline', length: 20);
            $table->softDeletes('deleted_at', precision: 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
