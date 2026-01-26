<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidate_endorsements', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('candidate_id')->constrained()->cascadeOnDelete();
            $table->foreignId('endorser_student_id')->constrained('students')->cascadeOnDelete();
            $table->timestamp('endorsement_date')->useCurrent();
            $table->text('remarks')->nullable();

            $table->unique(['candidate_id', 'endorser_student_id'], 'unique_candidate_endorser');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidate_endorsements');
    }
};
