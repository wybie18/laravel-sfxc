<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculty', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('employee_number', 50)->unique();
            $table->foreignId('department_id')->constrained();
            $table->enum('employment_type', ['full_time', 'part_time', 'contractual', 'visiting']);
            $table->enum('faculty_rank', ['instructor', 'assistant_professor', 'associate_professor', 'professor']);
            $table->string('specialization', 200)->nullable();
            $table->date('hire_date');
            $table->enum('employment_status', ['active', 'inactive', 'on_leave', 'retired', 'terminated'])->default('active');
            $table->timestamps();

            $table->index('employee_number', 'idx_employee_number');
            $table->index('department_id', 'idx_department');
        });

        // Add foreign key for dean_faculty_id in colleges table
        Schema::table('colleges', function (Blueprint $table): void {
            $table->foreign('dean_faculty_id')->references('id')->on('faculty')->nullOnDelete();
        });

        // Add foreign key for head_faculty_id in departments table
        Schema::table('departments', function (Blueprint $table): void {
            $table->foreign('head_faculty_id')->references('id')->on('faculty')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('colleges', function (Blueprint $table): void {
            $table->dropForeign(['dean_faculty_id']);
        });

        Schema::table('departments', function (Blueprint $table): void {
            $table->dropForeign(['head_faculty_id']);
        });

        Schema::dropIfExists('faculty');
    }
};
