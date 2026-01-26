<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('office_heads', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->foreignId('staff_id')->constrained()->cascadeOnDelete();
            $table->string('position_title', 100);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->string('appointment_order_number', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['office_id', 'is_current'], 'idx_office_current');
            $table->index('staff_id', 'idx_staff');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('office_heads');
    }
};
