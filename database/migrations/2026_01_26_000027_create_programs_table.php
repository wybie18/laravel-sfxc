<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('department_id')->constrained()->restrictOnDelete();
            $table->string('program_code', 20)->unique();
            $table->string('program_name', 200);
            $table->enum('program_type', ['undergraduate', 'graduate', 'doctorate', 'vocational']);
            $table->string('degree_type', 50)->nullable();
            $table->unsignedTinyInteger('duration_years');
            $table->unsignedSmallInteger('total_units');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('program_code', 'idx_code');
            $table->index('is_active', 'idx_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
