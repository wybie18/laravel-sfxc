<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_summaries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('class_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluation_period_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('total_respondents')->default(0);
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->timestamp('computed_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['class_section_id', 'evaluation_period_id'], 'unique_class_period');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_summaries');
    }
};
