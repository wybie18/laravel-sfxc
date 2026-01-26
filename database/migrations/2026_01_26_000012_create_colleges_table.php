<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colleges', function (Blueprint $table): void {
            $table->id();
            $table->string('college_code', 20)->unique();
            $table->string('college_name', 200);
            $table->string('acronym', 10)->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('dean_faculty_id')->nullable();
            $table->date('established_date')->nullable();
            $table->string('building_location', 100)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('college_code', 'idx_code');
            $table->index('dean_faculty_id', 'idx_dean');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colleges');
    }
};
