<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('election_positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('election_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('officer_position_id')->constrained()->cascadeOnDelete();

            $table->unsignedTinyInteger('slots_available')->default(1);
            $table->unsignedInteger('nomination_threshold')->default(5);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique(['election_id', 'student_organization_id', 'officer_position_id'], 'unique_election_org_position');
            $table->index('election_id', 'idx_election');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('election_positions');
    }
};
