<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_class_enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_section_id')->constrained()->cascadeOnDelete();
            $table->enum('enrollment_type', ['regular', 'add', 'drop', 'withdrawn'])->default('regular');
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamp('dropped_at')->nullable();
            $table->enum('status', ['active', 'dropped', 'completed', 'failed'])->default('active');
            $table->timestamps();

            $table->unique(['enrollment_id', 'class_section_id'], 'unique_enrollment_class');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class_enrollments');
    }
};
