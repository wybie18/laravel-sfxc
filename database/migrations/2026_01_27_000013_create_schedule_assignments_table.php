<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_assignments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_offering_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->constrained('faculty')->restrictOnDelete();
            $table->foreignId('room_id')->constrained()->restrictOnDelete();
            $table->enum('day', ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']);
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('meeting_type', ['lecture', 'laboratory', 'tutorial', 'hybrid'])->default('lecture');
            $table->enum('status', ['scheduled', 'cancelled', 'moved', 'conflict'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for conflict detection
            $table->index(['room_id', 'day', 'start_time', 'end_time'], 'idx_room_schedule');
            $table->index(['faculty_id', 'day', 'start_time', 'end_time'], 'idx_faculty_schedule');
            $table->index(['course_offering_id', 'day', 'start_time', 'end_time'], 'idx_offering_schedule');
            $table->index('day', 'idx_day');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_assignments');
    }
};
