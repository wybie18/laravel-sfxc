<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule_conflicts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('schedule_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('conflicting_assignment_id')->constrained('schedule_assignments')->cascadeOnDelete();
            $table->enum('conflict_type', ['room', 'faculty', 'section', 'time_overlap']);
            $table->text('description')->nullable();
            $table->enum('resolution_status', ['unresolved', 'resolved', 'ignored'])->default('unresolved');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();

            $table->index('schedule_assignment_id', 'idx_assignment');
            $table->index('conflict_type', 'idx_conflict_type');
            $table->index('resolution_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_conflicts');
    }
};
