<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_categories', function (Blueprint $table): void {
            $table->id();
            $table->string('category_name', 200);
            $table->text('description')->nullable();
            $table->decimal('weight_percentage', 5, 2)->default(0);
            $table->unsignedTinyInteger('order_sequence')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_categories');
    }
};
