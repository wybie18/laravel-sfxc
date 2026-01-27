<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table): void {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->string('label', 50)->nullable(); // e.g., "Morning 1", "Afternoon 2"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['start_time', 'end_time'], 'unique_time_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
