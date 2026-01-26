<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollment_fees', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fee_type_id')->constrained()->restrictOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('quantity', 5, 2)->default(1.00);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();

            $table->index('enrollment_id', 'idx_enrollment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_fees');
    }
};
