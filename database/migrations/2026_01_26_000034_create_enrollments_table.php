<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_program_id')->constrained()->cascadeOnDelete();
            $table->timestamp('enrollment_date')->useCurrent();
            $table->enum('enrollment_status', ['pending', 'approved', 'rejected', 'enrolled', 'withdrawn'])->default('pending');
            $table->unsignedTinyInteger('year_level');
            $table->decimal('total_units', 4, 1)->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'semester_id'], 'unique_student_semester');
            $table->index('enrollment_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
