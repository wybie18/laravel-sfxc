<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_results', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_position_id')->constrained()->cascadeOnDelete();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();

            $table->unsignedInteger('total_votes')->default(0);
            $table->decimal('vote_percentage', 5, 2)->nullable();
            $table->unsignedTinyInteger('ranking')->nullable();

            $table->boolean('is_winner')->default(false);
            $table->boolean('is_tie')->default(false);

            $table->timestamp('computed_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['election_position_id', 'candidate_id'], 'unique_position_candidate');
            $table->index('election_position_id', 'idx_position');
            $table->index('is_winner', 'idx_winner');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('election_results');
    }
};
