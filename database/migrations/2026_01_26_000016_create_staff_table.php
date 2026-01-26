<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('office_id')->nullable()->constrained()->nullOnDelete();
            $table->string('employee_number', 50)->unique();
            $table->foreignId('department_id')->constrained();
            $table->foreignId('staff_position_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('staff_level', ['staff', 'supervisor', 'head', 'director', 'admin'])->default('staff');
            $table->enum('employment_type', ['full_time', 'part_time', 'contractual']);
            $table->unsignedBigInteger('reports_to_staff_id')->nullable();
            $table->date('hire_date');
            $table->enum('employment_status', ['active', 'inactive', 'on_leave', 'retired', 'terminated'])->default('active');
            $table->timestamps();

            $table->foreign('reports_to_staff_id')->references('id')->on('staff')->nullOnDelete();

            $table->index('office_id', 'idx_office');
            $table->index('staff_level', 'idx_level');
            $table->index('reports_to_staff_id', 'idx_reports_to');
            $table->index('employee_number', 'idx_employee_number');
            $table->index('staff_position_id', 'idx_position');
            $table->index('department_id', 'idx_department');
        });

        // Add foreign key for office_head_staff_id in offices table
        Schema::table('offices', function (Blueprint $table): void {
            $table->foreign('office_head_staff_id')->references('id')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('offices', function (Blueprint $table): void {
            $table->dropForeign(['office_head_staff_id']);
        });

        Schema::dropIfExists('staff');
    }
};
