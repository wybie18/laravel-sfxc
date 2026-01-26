<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_programs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->restrictOnDelete();
            $table->date('enrollment_date');
            $table->date('expected_graduation_date')->nullable();
            $table->enum('status', ['active', 'transferred', 'graduated', 'withdrawn'])->default('active');
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->index(['student_id', 'is_current'], 'idx_student_current');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_programs');
    }
};
