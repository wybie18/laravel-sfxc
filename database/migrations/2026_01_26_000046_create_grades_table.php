<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_class_enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_grading_structure_id')->constrained()->cascadeOnDelete();
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2)->default(100.00);
            $table->decimal('percentage', 5, 2)->storedAs('(score / max_score) * 100');
            $table->text('remarks')->nullable();
            $table->foreignId('recorded_by')->constrained('users')->restrictOnDelete();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->index(['student_class_enrollment_id', 'class_grading_structure_id'], 'idx_enrollment_component');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
