<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_system_role')->default(false);
            $table->timestamps();

            $table->index('slug', 'idx_slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
