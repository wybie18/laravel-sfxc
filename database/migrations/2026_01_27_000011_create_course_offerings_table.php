<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_offerings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('program_section_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('year_level');
            $table->string('effectivity_year', 20)->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'published', 'archived'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('semester_id', 'idx_semester');
            $table->index('program_id', 'idx_program');
            $table->index('program_section_id', 'idx_section');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_offerings');
    }
};
