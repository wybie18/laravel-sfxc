<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offices', function (Blueprint $table): void {
            $table->id();
            $table->string('office_code', 20)->unique();
            $table->string('office_name', 200);
            $table->enum('office_type', ['administrative', 'academic', 'support', 'auxiliary']);
            $table->unsignedBigInteger('parent_office_id')->nullable();
            $table->text('description')->nullable();
            $table->string('building_location', 100)->nullable();
            $table->string('room_number', 50)->nullable();
            $table->string('contact_email', 100)->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->unsignedBigInteger('office_head_staff_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_office_id')->references('id')->on('offices')->nullOnDelete();

            $table->index('office_code', 'idx_code');
            $table->index('office_type', 'idx_type');
            $table->index('parent_office_id', 'idx_parent');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
