<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_position_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // Candidacy details
            $table->timestamp('nomination_date')->useCurrent();
            $table->enum('nomination_type', ['self', 'party', 'endorsed'])->default('self');
            $table->string('party_affiliation', 100)->nullable();

            // Platform
            $table->string('platform_title', 255)->nullable();
            $table->text('platform_statement')->nullable();
            $table->string('photo_path', 255)->nullable();

            // Status
            $table->enum('candidate_status', ['nominated', 'verified', 'approved', 'rejected', 'withdrew', 'disqualified'])->default('nominated');

            // Verification
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_remarks')->nullable();

            // Disqualification
            $table->foreignId('disqualified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disqualified_at')->nullable();
            $table->text('disqualification_reason')->nullable();

            $table->timestamps();

            $table->unique(['election_position_id', 'student_id'], 'unique_candidate_position');
            $table->index('student_id', 'idx_student');
            $table->index('candidate_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
