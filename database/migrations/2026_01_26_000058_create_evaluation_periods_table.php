<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_periods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('period_name', 100);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->index(['semester_id', 'is_active'], 'idx_semester_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_periods');
    }
};
