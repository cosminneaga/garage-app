<?php

use App\Models\Address;
use App\Models\Supplier;
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
        Schema::create('address_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Address::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Supplier::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses_suppliers');
    }
};
