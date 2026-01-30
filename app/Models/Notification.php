<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * Notification Model
 *
 * Represents a notification sent to a user.
 *
 * @property int $id
 * @property int $user_id
 * @property string $notification_type
 * @property string $title
 * @property string $message
 * @property string $channel
 * @property string|null $notifiable_type
 * @property int|null $notifiable_id
 * @property Carbon|null $read_at
 * @property Carbon|null $sent_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read Model|null $notifiable
 */
final class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'notification_type',
        'title',
        'message',
        'channel',
        'notifiable_type',
        'notifiable_id',
        'read_at',
        'sent_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
            'sent_at' => 'datetime',
        ];
    }

    /**
     * Get the user.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notifiable model (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if the notification is read.
     */
    public function isRead(): bool
    {
        return $this->read_at !== null;
    }
}
