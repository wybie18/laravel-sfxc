<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_criteria', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('evaluation_category_id')->constrained()->cascadeOnDelete();
            $table->text('criteria_text');
            $table->enum('criteria_type', ['rating', 'yes_no', 'text'])->default('rating');
            $table->unsignedTinyInteger('rating_scale')->default(5);
            $table->unsignedTinyInteger('order_sequence')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('evaluation_category_id', 'idx_category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_criteria');
    }
};
