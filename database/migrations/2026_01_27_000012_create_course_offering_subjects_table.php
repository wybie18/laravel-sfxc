<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_offering_subjects', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('course_offering_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('curriculum_id')->nullable()->constrained('curriculum')->nullOnDelete();
            $table->foreignId('specialization_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->unique(['course_offering_id', 'subject_id'], 'unique_offering_subject');
            $table->index('subject_id', 'idx_subject');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_offering_subjects');
    }
};
