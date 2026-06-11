<?php

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
        Schema::create('team_administrator_managers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('administrator_id');
            $table->foreign('administrator_id', 'team_administrator_id_foreign')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'manager_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_administrator_manager');
    }
};
