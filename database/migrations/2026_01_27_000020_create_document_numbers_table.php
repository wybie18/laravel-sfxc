<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_numbers', function (Blueprint $table): void {
            $table->id();
            $table->string('document_number')->unique();
            $table->date('effective_date');
            $table->string('revision_number', 20);
            $table->string('document_type', 50)->nullable(); // 'schedule', 'load', 'offering'
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('document_type', 'idx_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_numbers');
    }
};
