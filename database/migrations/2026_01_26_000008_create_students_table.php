<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('student_number', 50)->unique();
            $table->date('admission_date');
            $table->enum('student_type', ['regular', 'irregular', 'transferee', 'returning'])->default('regular');
            $table->enum('student_status', ['active', 'inactive', 'graduated', 'dropped', 'suspended'])->default('active');
            $table->unsignedTinyInteger('current_year_level')->nullable();
            $table->string('scholarship_type', 100)->nullable();
            $table->timestamps();

            $table->index('student_number', 'idx_student_number');
            $table->index('student_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
