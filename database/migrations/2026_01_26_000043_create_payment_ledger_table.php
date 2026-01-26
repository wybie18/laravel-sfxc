<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_ledger', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->enum('action', ['created', 'updated', 'completed', 'failed', 'refunded', 'cancelled']);
            $table->string('previous_status', 50)->nullable();
            $table->string('new_status', 50)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->foreignId('performed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('payment_id', 'idx_payment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_ledger');
    }
};
