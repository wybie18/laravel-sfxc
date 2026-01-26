<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_requests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clearance_type_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('request_date')->useCurrent();
            $table->text('purpose')->nullable();
            $table->enum('overall_status', ['pending', 'in_progress', 'completed', 'rejected', 'cancelled'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'overall_status'], 'idx_student_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_requests');
    }
};
