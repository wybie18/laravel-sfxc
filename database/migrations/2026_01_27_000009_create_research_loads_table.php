<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('research_loads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_id')->constrained('faculty')->cascadeOnDelete();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('load_code', 20)->nullable();
            $table->string('load_description');
            $table->string('research_title')->nullable();
            $table->decimal('units', 4, 1);
            $table->enum('status', ['ongoing', 'completed', 'suspended'])->default('ongoing');
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index('faculty_id', 'idx_faculty');
            $table->index('semester_id', 'idx_semester');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_loads');
    }
};
