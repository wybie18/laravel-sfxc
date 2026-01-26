<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_guardians', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('guardian_name', 200);
            $table->string('relationship', 50);
            $table->string('contact_number', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('occupation', 100)->nullable();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index('student_id', 'idx_student');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_guardians');
    }
};
