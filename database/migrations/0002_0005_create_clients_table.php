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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 40);
            $table->string('email')->unique();
            $table->boolean('active');
            $table->string('password')->nullable(false);
            $table->string('access_token')->nullable();

            $table->auditColumns();

            $table->index('name', 'cl_name_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client', function (Blueprint $table) {
            $table->dropIndex('cl_name_idx');
        });

        Schema::dropIfExists('clients');
    }
};
