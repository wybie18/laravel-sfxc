<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_signatures', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clearance_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('clearance_signatory_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'approved', 'rejected', 'with_remarks'])->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();

            $table->unique(['clearance_request_id', 'clearance_signatory_id'], 'unique_request_signatory');
            $table->index('status', 'idx_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_signatures');
    }
};
