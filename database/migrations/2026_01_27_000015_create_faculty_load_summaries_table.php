<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_load_summaries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();

            // Teaching load
            $table->decimal('total_teaching_units', 4, 1)->default(0);
            $table->decimal('regular_load_units', 4, 1)->default(0);
            $table->decimal('overload_units', 4, 1)->default(0);
            $table->decimal('extra_load_units', 4, 1)->default(0);
            $table->decimal('total_contact_hours', 5, 1)->default(0);

            // Other loads
            $table->decimal('administrative_units', 4, 1)->default(0);
            $table->decimal('research_units', 4, 1)->default(0);

            // Totals
            $table->decimal('grand_total_units', 5, 1)->default(0);
            $table->unsignedTinyInteger('max_allowed_units')->default(24);
            $table->boolean('is_overloaded')->default(false);

            $table->timestamp('computed_at')->useCurrent();
            $table->timestamps();

            $table->unique(['faculty_id', 'semester_id'], 'unique_faculty_semester');
            $table->index('semester_id', 'idx_semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_load_summaries');
    }
};
