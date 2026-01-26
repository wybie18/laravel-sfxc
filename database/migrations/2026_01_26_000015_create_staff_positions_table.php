<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_positions', function (Blueprint $table): void {
            $table->id();
            $table->string('position_code', 20)->unique();
            $table->string('position_title', 100);
            $table->enum('position_level', ['entry', 'mid', 'senior', 'managerial', 'executive']);
            $table->foreignId('office_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->text('job_description')->nullable();
            $table->text('required_qualifications')->nullable();
            $table->string('salary_grade', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('position_code', 'idx_code');
            $table->index('position_level', 'idx_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_positions');
    }
};
