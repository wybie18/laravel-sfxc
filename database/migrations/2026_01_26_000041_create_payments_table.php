<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->string('payment_reference', 100)->unique();
            $table->foreignId('enrollment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained()->restrictOnDelete();
            $table->decimal('amount_paid', 10, 2);
            $table->timestamp('payment_date')->useCurrent();
            $table->enum('payment_status', ['pending', 'processing', 'completed', 'failed', 'refunded', 'cancelled'])->default('pending');
            $table->string('transaction_id', 255)->nullable();
            $table->string('receipt_number', 100)->unique()->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('payment_reference', 'idx_reference');
            $table->index('enrollment_id', 'idx_enrollment');
            $table->index('payment_status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
