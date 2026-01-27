<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_change_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('schedule_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->enum('change_type', ['reschedule', 'room_change', 'faculty_change', 'cancel']);

            // Proposed changes
            $table->foreignId('proposed_room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->enum('proposed_day', ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'])->nullable();
            $table->time('proposed_start_time')->nullable();
            $table->time('proposed_end_time')->nullable();
            $table->foreignId('proposed_faculty_id')->nullable()->constrained('faculty')->nullOnDelete();

            $table->text('reason');
            $table->date('effective_date')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('review_remarks')->nullable();

            $table->timestamps();

            $table->index('schedule_assignment_id', 'idx_assignment');
            $table->index('status', 'idx_status');
            $table->index('requested_by', 'idx_requested_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_change_requests');
    }
};
