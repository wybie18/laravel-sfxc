<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_types', function (Blueprint $table): void {
            $table->id();
            $table->string('fee_code', 20)->unique();
            $table->string('fee_name', 200);
            $table->text('description')->nullable();
            $table->decimal('default_amount', 10, 2);
            $table->boolean('is_per_unit')->default(false);
            $table->boolean('is_required')->default(true);
            $table->enum('applicable_to', ['all', 'undergraduate', 'graduate', 'specific_program'])->default('all');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_types');
    }
};
