<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table): void {
            $table->id();
            $table->string('department_code', 20)->unique();
            $table->string('department_name', 200);
            $table->text('description')->nullable();
            $table->unsignedBigInteger('head_faculty_id')->nullable();
            $table->foreignId('college_id')->constrained();
            $table->timestamps();
            $table->softDeletes();

            $table->index('department_code', 'idx_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
