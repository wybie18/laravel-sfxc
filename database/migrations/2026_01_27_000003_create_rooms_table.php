<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('building_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_type_id')->constrained()->restrictOnDelete();
            $table->string('code');
            $table->string('name')->nullable();
            $table->unsignedSmallInteger('capacity')->default(40);
            $table->string('floor', 10)->nullable();
            $table->boolean('has_ac')->default(false);
            $table->boolean('has_projector')->default(false);
            $table->boolean('has_whiteboard')->default(true);
            $table->boolean('is_active')->default(true);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['building_id', 'code'], 'unique_building_room');
            $table->index('room_type_id', 'idx_room_type');
            $table->index('is_active', 'idx_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
