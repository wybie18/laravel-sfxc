<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_protests', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('filed_by_student_id')->constrained('students')->cascadeOnDelete();

            $table->enum('protest_type', ['irregularity', 'disqualification', 'recount', 'other']);
            $table->foreignId('subject_candidate_id')->nullable()->constrained('candidates')->nullOnDelete();

            $table->text('complaint');
            $table->json('evidence_files')->nullable(); // array of file paths

            $table->timestamp('filed_at')->useCurrent();

            // Resolution
            $table->enum('protest_status', ['pending', 'investigating', 'resolved', 'dismissed'])->default('pending');
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution')->nullable();

            $table->timestamps();

            $table->index('election_id', 'idx_election');
            $table->index('protest_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('election_protests');
    }
};
