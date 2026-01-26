<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('elections', function (Blueprint $table): void {
            $table->id();
            $table->string('election_code', 20)->unique();
            $table->string('election_name', 200);
            $table->foreignId('academic_year_id')->constrained()->restrictOnDelete();

            // Election scope
            $table->enum('election_level', ['university', 'college', 'program', 'department']);
            $table->nullableMorphs('scope');

            // Dates
            $table->timestamp('nomination_start_date');
            $table->timestamp('nomination_end_date');
            $table->timestamp('campaign_start_date');
            $table->timestamp('campaign_end_date');
            $table->timestamp('voting_start_date');
            $table->timestamp('voting_end_date');

            // Settings
            $table->enum('election_type', ['general', 'special', 'recall', 'by_election'])->default('general');
            $table->enum('voting_method', ['online', 'manual', 'hybrid'])->default('online');
            $table->boolean('requires_verification')->default(true);
            $table->boolean('allow_abstain')->default(true);
            $table->enum('results_visibility', ['immediate', 'after_close', 'manual'])->default('after_close');

            // Status
            $table->enum('election_status', ['draft', 'nomination', 'campaign', 'voting', 'tallying', 'completed', 'cancelled'])->default('draft');

            // Results
            $table->unsignedInteger('total_eligible_voters')->default(0);
            $table->unsignedInteger('total_votes_cast')->default(0);
            $table->decimal('voter_turnout_percentage', 5, 2)->nullable();

            // Officials
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('supervised_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('finalized_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('finalized_at')->nullable();

            $table->text('description')->nullable();
            $table->text('guidelines')->nullable();

            $table->timestamps();

            $table->index('election_status', 'idx_status');
            $table->index('election_level', 'idx_level');
            $table->index(['voting_start_date', 'voting_end_date'], 'idx_voting_dates');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('elections');
    }
};
