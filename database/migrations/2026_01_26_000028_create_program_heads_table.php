<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_heads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('program_id')->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->string('position_title', 100)->default('Program Head');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('appointment_order_number', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['program_id', 'is_current'], 'idx_program_current');
            $table->index('faculty_id', 'idx_faculty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_heads');
    }
};
