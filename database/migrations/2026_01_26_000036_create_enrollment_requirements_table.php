<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment_requirements', function (Blueprint $table): void {
            $table->id();
            $table->string('requirement_name', 200);
            $table->text('description')->nullable();
            $table->boolean('is_mandatory')->default(true);
            $table->unsignedTinyInteger('required_for_year_level')->nullable();
            $table->string('document_type', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_requirements');
    }
};
