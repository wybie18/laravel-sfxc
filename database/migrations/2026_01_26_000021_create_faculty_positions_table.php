<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty_positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->enum('position_type', ['department_head', 'program_head', 'college_dean', 'coordinator', 'chair', 'director']);
            $table->string('entity_type', 50);
            $table->unsignedBigInteger('entity_id');
            $table->string('position_title', 100)->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->decimal('additional_compensation', 10, 2)->default(0.00);
            $table->decimal('workload_units', 4, 1)->default(0.0);
            $table->timestamps();

            $table->index(['faculty_id', 'is_current'], 'idx_faculty_current');
            $table->index('position_type', 'idx_position_type');
            $table->index(['entity_type', 'entity_id'], 'idx_entity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faculty_positions');
    }
};
