<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_news_interactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('news_post_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_read')->default(false);
            $table->boolean('is_bookmarked')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'news_post_id'], 'unique_user_news');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_news_interactions');
    }
};
