<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_prerequisites', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('prerequisite_subject_id');
            $table->boolean('is_corequisite')->default(false);
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('prerequisite_subject_id')->references('id')->on('subjects')->cascadeOnDelete();
            $table->unique(['subject_id', 'prerequisite_subject_id'], 'unique_prerequisite');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subject_prerequisites');
    }
};
