<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_workload', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->decimal('total_units', 4, 1)->default(0.0);
            $table->decimal('teaching_units', 4, 1)->default(0.0);
            $table->decimal('admin_units', 4, 1)->default(0.0);
            $table->decimal('research_units', 4, 1)->default(0.0);
            $table->decimal('overload_units', 4, 1)->default(0.0);
            $table->boolean('is_overload')->default(false);
            $table->timestamps();

            $table->unique(['faculty_id', 'semester_id'], 'unique_faculty_semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_workload');
    }
};
