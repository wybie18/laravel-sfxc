<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('year_level');
            $table->unsignedTinyInteger('semester');
            $table->boolean('is_required')->default(true);
            $table->foreignId('effective_academic_year_id')->constrained('academic_years')->restrictOnDelete();
            $table->timestamps();

            $table->index(['program_id', 'year_level', 'semester'], 'idx_program_year');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum');
    }
};
