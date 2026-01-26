<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->enum('address_type', ['current', 'permanent', 'billing']);
            $table->string('street_address', 255)->nullable();
            $table->string('barangay', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 50)->default('Philippines');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['person_id', 'address_type'], 'idx_person_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
