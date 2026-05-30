<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tax_id');
            $table->string('registration_number');
            $table->decimal('tax_value', 4, 2)->default(20.00);
            $table->string('invoice_prefix')->nullable(false);
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('name', 'cmp_name_idx');
            $table->index('tax_id', 'cmp_taxid_idx');
            $table->index('tax_value', 'cmp_taxvalue_idx');
            $table->index('registration_number', 'cmp_registrationnumber_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex('cmp_name_idx');
            $table->dropIndex('cmp_taxid_idx');
            $table->dropIndex('cmp_taxvalue_idx');
            $table->dropIndex('cmp_registrationnumber_idx');
        });

        Schema::dropIfExists('companies');
    }
};
