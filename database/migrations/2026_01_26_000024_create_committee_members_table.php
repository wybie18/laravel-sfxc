<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committee_members', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('committee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('member_role', ['chairperson', 'co_chair', 'member', 'secretary', 'adviser'])->default('member');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('committee_id', 'idx_committee');
            $table->index('user_id', 'idx_user');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
