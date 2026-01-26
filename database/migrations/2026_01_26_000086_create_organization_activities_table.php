<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_organization_id')->constrained()->cascadeOnDelete();

            $table->string('activity_name', 255);
            $table->enum('activity_type', ['meeting', 'workshop', 'seminar', 'outreach', 'competition', 'social', 'fundraising']);
            $table->text('description')->nullable();

            $table->string('venue', 255)->nullable();
            $table->date('activity_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->foreignId('organizer_officer_id')->nullable()->constrained('student_officers')->nullOnDelete();

            $table->decimal('budget_allocated', 10, 2)->default(0.00);
            $table->decimal('actual_expenses', 10, 2)->default(0.00);

            $table->unsignedInteger('participant_count')->default(0);

            $table->enum('status', ['planned', 'ongoing', 'completed', 'cancelled'])->default('planned');

            $table->timestamps();

            $table->index('student_organization_id', 'idx_organization');
            $table->index('activity_date', 'idx_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_activities');
    }
};
