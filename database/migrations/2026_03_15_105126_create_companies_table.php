<?php

use App\Models\Country;
use App\Models\User;
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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 255);
            $table->string('email', length: 30);
            $table->string('street', length: 255);
            $table->string('city', length: 30);
            $table->string('postcode', length: 15);
            $table->foreignIdFor(Country::class)->constrained()->nullable();
            $table->string('registration_no', length: 20);
            $table->string('mobile', length: 20);
            $table->string('landline', length: 20);
            $table->integer('tax_value')->default(20);
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
