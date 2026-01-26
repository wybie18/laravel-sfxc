<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table): void {
            $table->id();
            $table->string('subject_code', 20)->unique();
            $table->string('subject_name', 200);
            $table->text('description')->nullable();
            $table->decimal('units', 3, 1);
            $table->decimal('lecture_hours', 3, 1)->default(0);
            $table->decimal('lab_hours', 3, 1)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('subject_code', 'idx_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
