<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('election_position_id')->constrained()->cascadeOnDelete();
            $table->foreignId('voter_student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('candidate_id')->nullable()->constrained()->cascadeOnDelete(); // NULL for abstain

            $table->enum('vote_type', ['candidate', 'abstain'])->default('candidate');

            // Anonymity & Security
            $table->string('vote_hash', 64)->unique(); // SHA-256 hash for verification
            $table->timestamp('voted_at')->useCurrent();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            // Verification
            $table->boolean('is_verified')->default(true);

            $table->unique(['election_position_id', 'voter_student_id'], 'unique_voter_position');
            $table->index('election_id', 'idx_election');
            $table->index('candidate_id', 'idx_candidate');
            $table->index('voted_at', 'idx_voted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
