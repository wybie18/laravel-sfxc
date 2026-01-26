<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_deficiencies', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clearance_signature_id')->constrained()->cascadeOnDelete();
            $table->string('deficiency_type', 100);
            $table->text('description');
            $table->decimal('amount_due', 10, 2)->nullable();
            $table->boolean('is_resolved')->default(false);
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['clearance_signature_id', 'is_resolved'], 'idx_signature_resolved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_deficiencies');
    }
};
