<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('room_reservations', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('day', ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN']);
            $table->time('start_time');
            $table->time('end_time');
            $table->date('specific_date')->nullable(); // For one-time reservations
            $table->enum('reservation_type', ['class', 'event', 'meeting', 'maintenance', 'blocked']);
            $table->string('purpose');
            $table->foreignId('reserved_by')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->index(['room_id', 'day', 'start_time', 'end_time'], 'idx_room_reservation');
            $table->index('specific_date', 'idx_specific_date');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('room_reservations');
    }
};
