<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('final_grades', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_class_enrollment_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('midterm_grade', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2);
            $table->char('letter_grade', 5)->nullable();
            $table->boolean('is_passed')->nullable();
            $table->enum('remarks', ['passed', 'failed', 'incomplete', 'dropped', 'withdrew']);
            $table->enum('completion_status', ['completed', 'ongoing', 'incomplete'])->default('ongoing');
            $table->foreignId('finalized_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('finalized_at')->nullable();
            $table->timestamps();

            $table->index('student_class_enrollment_id', 'idx_enrollment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('final_grades');
    }
};
