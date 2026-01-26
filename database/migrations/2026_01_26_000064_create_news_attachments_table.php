<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_attachments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('news_post_id')->constrained()->cascadeOnDelete();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_type', 50)->nullable();
            $table->unsignedInteger('file_size')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('news_post_id', 'idx_news_post');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_attachments');
    }
};
