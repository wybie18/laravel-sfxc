<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_organizations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_type_id')->constrained()->restrictOnDelete();
            $table->string('organization_code', 20)->unique();
            $table->string('organization_name', 200);
            $table->string('acronym', 20)->nullable();
            $table->enum('level', ['university', 'college', 'program', 'department', 'special']);

            // Polymorphic relationship for different levels
            $table->nullableMorphs('parent');

            $table->text('description')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->date('established_date')->nullable();
            $table->foreignId('adviser_faculty_id')->nullable()->constrained('faculty')->nullOnDelete();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index('level', 'idx_level');
            $table->index('is_active', 'idx_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_organizations');
    }
};
