<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_types', function (Blueprint $table): void {
            $table->id();
            $table->string('type_code', 20)->unique();
            $table->string('type_name', 100);
            $table->enum('level', ['university', 'college', 'program', 'department', 'special']);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_types');
    }
};
