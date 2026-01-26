<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('suffix', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('nationality', 50)->nullable();
            $table->enum('civil_status', ['single', 'married', 'widowed', 'divorced', 'separated'])->nullable();
            $table->string('profile_photo_path', 255)->nullable();
            $table->timestamps();

            $table->index(['last_name', 'first_name'], 'idx_full_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
