<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            $table->enum('membership_type', ['regular', 'associate', 'honorary', 'alumni'])->default('regular');
            $table->enum('membership_status', ['active', 'inactive', 'suspended', 'expelled'])->default('active');

            $table->date('joined_date');
            $table->date('left_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->unique(['student_organization_id', 'student_id'], 'unique_org_student');
            $table->index('student_id', 'idx_student');
            $table->index('membership_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_members');
    }
};
