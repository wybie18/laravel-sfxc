<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eligible_voters', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            $table->enum('eligibility_status', ['eligible', 'ineligible', 'suspended'])->default('eligible');
            $table->text('ineligibility_reason')->nullable();

            $table->boolean('has_voted')->default(false);
            $table->timestamp('voted_at')->nullable();

            $table->timestamps();

            $table->unique(['election_id', 'student_id'], 'unique_election_voter');
            $table->index('election_id', 'idx_election');
            $table->index('student_id', 'idx_student');
            $table->index('has_voted', 'idx_voted');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eligible_voters');
    }
};
