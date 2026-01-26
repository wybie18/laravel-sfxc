<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_evaluations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_class_enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluation_period_id')->constrained()->cascadeOnDelete();
            $table->timestamp('submitted_at')->useCurrent();
            $table->boolean('is_anonymous')->default(true);
            $table->decimal('overall_rating', 3, 2)->nullable();
            $table->text('comments')->nullable();
            $table->timestamps();

            $table->unique(['student_class_enrollment_id', 'evaluation_period_id'], 'unique_enrollment_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_evaluations');
    }
};
