<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_cumulative_gpa', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_program_id')->unique()->constrained()->cascadeOnDelete();
            $table->decimal('cumulative_gpa', 3, 2);
            $table->decimal('total_units_earned', 5, 1);
            $table->timestamp('last_computed_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_cumulative_gpa');
    }
};
