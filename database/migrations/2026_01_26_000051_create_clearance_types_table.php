<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_types', function (Blueprint $table): void {
            $table->id();
            $table->string('clearance_code', 20)->unique();
            $table->string('clearance_name', 200);
            $table->text('description')->nullable();
            $table->enum('required_for', ['enrollment', 'graduation', 'transfer', 'honorable_dismissal', 'general']);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_types');
    }
};
