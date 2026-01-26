<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_information', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('person_id')->constrained('people')->cascadeOnDelete();
            $table->enum('contact_type', ['mobile', 'landline', 'email', 'emergency']);
            $table->string('contact_value', 100);
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->index(['person_id', 'contact_type'], 'idx_person_contact');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_information');
    }
};
