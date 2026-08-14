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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('code');
            $table->string('type')->default('distributor');
            $table->string('tax_id');
            $table->string('registration_number');

            $table->auditColumns();

            $table->index('name', 'sup_name_idx');
            $table->index('code', 'sup_code_idx');
            $table->index('type', 'sup_type_idx');
            $table->index('tax_id', 'sup_tax_id_idx');
            $table->index('registration_number', 'sup_registration_number_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropIndex('sup_name_idx');
            $table->dropIndex('sup_code_idx');
            $table->dropIndex('sup_type_idx');
            $table->dropIndex('sup_tax_id_idx');
            $table->dropIndex('sup_registration_number_idx');
        });

        Schema::dropIfExists('suppliers');
    }
};
