<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_teaching_loads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_assignment_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('contact_hours', 4, 1);
            $table->decimal('units', 4, 1);
            $table->enum('load_type', ['regular', 'overload', 'extra'])->default('regular');
            $table->timestamps();

            $table->index('faculty_id', 'idx_faculty');
            $table->index('semester_id', 'idx_semester');
            $table->index('subject_id', 'idx_subject');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_teaching_loads');
    }
};
