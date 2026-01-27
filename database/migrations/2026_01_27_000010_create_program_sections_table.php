<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('section_name', 50);
            $table->unsignedTinyInteger('year_level');
            $table->foreignId('program_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('specialization_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedSmallInteger('max_students')->default(40);
            $table->enum('status', ['active', 'inactive', 'merged'])->default('active');
            $table->timestamps();

            $table->index('program_id', 'idx_program');
            $table->index('year_level', 'idx_year_level');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_sections');
    }
};
