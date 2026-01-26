<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committees', function (Blueprint $table): void {
            $table->id();
            $table->string('committee_code', 20)->unique();
            $table->string('committee_name', 200);
            $table->enum('committee_type', ['academic', 'administrative', 'disciplinary', 'special', 'standing']);
            $table->unsignedBigInteger('parent_committee_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('chairperson_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_committee_id')->references('id')->on('committees')->nullOnDelete();

            $table->index('committee_type', 'idx_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('committees');
    }
};
