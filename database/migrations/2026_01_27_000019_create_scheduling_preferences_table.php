<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduling_preferences', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('semester_id')->constrained()->cascadeOnDelete();
            $table->string('preference_key', 100);
            $table->text('preference_value');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->unique(['semester_id', 'preference_key'], 'unique_semester_preference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scheduling_preferences');
    }
};
