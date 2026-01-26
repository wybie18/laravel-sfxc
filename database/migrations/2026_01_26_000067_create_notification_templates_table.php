<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table): void {
            $table->id();
            $table->string('template_code', 50)->unique();
            $table->string('template_name', 200);
            $table->string('subject', 255)->nullable();
            $table->text('body_template');
            $table->enum('notification_type', ['email', 'sms', 'in_app', 'push']);
            $table->string('event_trigger', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
