<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clearance_signatories', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('clearance_type_id')->constrained()->cascadeOnDelete();
            $table->string('office_name', 200);
            $table->string('office_code', 50);
            $table->foreignId('signatory_role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('order_sequence')->default(1);
            $table->boolean('is_required')->default(true);
            $table->timestamps();

            $table->index('clearance_type_id', 'idx_clearance_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clearance_signatories');
    }
};
