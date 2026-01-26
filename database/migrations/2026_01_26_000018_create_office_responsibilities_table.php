<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('office_responsibilities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->string('responsibility_name', 200);
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('priority')->default(1);
            $table->timestamps();

            $table->index('office_id', 'idx_office');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('office_responsibilities');
    }
};
