<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_officers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('officer_position_id')->constrained()->cascadeOnDelete();

            // Term details
            $table->date('term_start_date');
            $table->date('term_end_date');
            $table->foreignId('academic_year_id')->constrained()->restrictOnDelete();

            // Status
            $table->enum('officer_status', ['active', 'completed', 'resigned', 'removed', 'suspended'])->default('active');
            $table->enum('appointment_type', ['elected', 'appointed', 'interim'])->default('elected');

            // Reports to (actual officer, not position)
            $table->unsignedBigInteger('reports_to_officer_id')->nullable();

            // Appointment details
            $table->foreignId('election_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('appointed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('appointment_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->foreign('reports_to_officer_id')->references('id')->on('student_officers')->nullOnDelete();

            $table->index('student_id', 'idx_student');
            $table->index('student_organization_id', 'idx_organization');
            $table->index('officer_status', 'idx_status');
            $table->index(['term_start_date', 'term_end_date'], 'idx_term');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_officers');
    }
};
