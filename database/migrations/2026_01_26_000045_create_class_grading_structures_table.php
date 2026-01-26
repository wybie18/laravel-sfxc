<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_grading_structures', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('class_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grading_component_id')->constrained()->cascadeOnDelete();
            $table->decimal('weight_percentage', 5, 2);
            $table->decimal('passing_score', 5, 2)->default(60.00);
            $table->timestamps();

            $table->unique(['class_section_id', 'grading_component_id'], 'unique_class_component');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_grading_structures');
    }
};
