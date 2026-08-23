<?php

use App\Enums\FileType;
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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable(false);
            $table->string('extension')->nullable(false);
            $table->string('path')->nullable(false);
            $table->string('type')->default(FileType::OTHER->value);
            $table->longText('description')->nullable();

            $table->foreignIdFor(User::class, 'uploaded_by')->constrained()->cascadeOnUpdate();

            $table->auditColumns();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
