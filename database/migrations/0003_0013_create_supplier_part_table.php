<?php

use App\Models\Part;
use App\Models\Supplier;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('supplier_part', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Supplier::class)->constrained()->cascadeOnUpdate();
            $table->foreignIdFor(Part::class)->constrained()->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_part');
    }
};
