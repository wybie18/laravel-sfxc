<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_heads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('appointment_order_number', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['department_id', 'is_current'], 'idx_department_current');
            $table->index('faculty_id', 'idx_faculty');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_heads');
    }
};
