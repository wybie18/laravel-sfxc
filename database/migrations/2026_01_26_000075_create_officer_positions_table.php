<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('officer_positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('organization_type_id')->constrained()->cascadeOnDelete();
            $table->string('position_code', 20);
            $table->string('position_name', 100);
            $table->unsignedTinyInteger('position_level'); // 1=President, 2=VP, 3=Secretary, etc.
            $table->unsignedBigInteger('parent_position_id')->nullable();
            $table->unsignedBigInteger('reports_to_position_id')->nullable();

            $table->text('responsibilities')->nullable();
            $table->text('qualifications')->nullable();
            $table->unsignedTinyInteger('term_duration_months')->default(12);
            $table->unsignedTinyInteger('max_consecutive_terms')->default(1);
            $table->decimal('voting_weight', 3, 2)->default(1.00);

            $table->unsignedTinyInteger('order_sequence')->default(1);
            $table->boolean('is_elected')->default(true);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->foreign('parent_position_id')->references('id')->on('officer_positions')->nullOnDelete();
            $table->foreign('reports_to_position_id')->references('id')->on('officer_positions')->nullOnDelete();

            $table->unique(['organization_type_id', 'position_code'], 'unique_org_position');
            $table->index('position_level', 'idx_level');
            $table->index('parent_position_id', 'idx_parent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('officer_positions');
    }
};
