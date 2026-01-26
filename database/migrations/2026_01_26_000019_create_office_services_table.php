<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('office_services', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('office_id')->constrained()->cascadeOnDelete();
            $table->string('service_name', 200);
            $table->string('service_code', 20)->unique();
            $table->text('description')->nullable();
            $table->string('processing_time', 100)->nullable();
            $table->text('requirements')->nullable();
            $table->decimal('fee_amount', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('office_id', 'idx_office');
            $table->index('service_code', 'idx_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('office_services');
    }
};
