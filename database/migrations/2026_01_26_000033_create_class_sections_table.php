<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_sections', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('section_name', 50);
            $table->foreignId('faculty_id')->nullable()->constrained('faculty')->nullOnDelete();
            $table->string('room', 50)->nullable();
            $table->string('schedule_days', 50)->nullable();
            $table->time('schedule_time_start')->nullable();
            $table->time('schedule_time_end')->nullable();
            $table->unsignedSmallInteger('max_students')->default(40);
            $table->unsignedSmallInteger('current_enrolled')->default(0);
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->timestamps();

            $table->index(['semester_id', 'subject_id'], 'idx_semester_subject');
            $table->index('faculty_id', 'idx_faculty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_sections');
    }
};
