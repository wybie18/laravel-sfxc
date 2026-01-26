<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_enrollment_requirements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('requirement_id')->constrained('enrollment_requirements')->cascadeOnDelete();
            $table->string('file_path', 255)->nullable();
            $table->timestamp('submission_date')->useCurrent();
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->unique(['enrollment_id', 'requirement_id'], 'unique_enrollment_requirement');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_enrollment_requirements');
    }
};
