<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_availabilities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->enum('day', ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']);
            $table->foreignId('time_slot_id')->constrained()->restrictOnDelete();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_preferred')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['faculty_id', 'semester_id', 'day', 'time_slot_id'], 'unique_faculty_semester_day_slot');
            $table->index('time_slot_id', 'idx_time_slot');
            $table->index(['faculty_id', 'semester_id'], 'idx_faculty_semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_availabilities');
    }
};
