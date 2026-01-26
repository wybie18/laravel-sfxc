<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_responses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('faculty_evaluation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluation_criteria_id')->constrained('evaluation_criteria')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating_value')->nullable();
            $table->text('text_response')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['faculty_evaluation_id', 'evaluation_criteria_id'], 'unique_evaluation_criteria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_responses');
    }
};
