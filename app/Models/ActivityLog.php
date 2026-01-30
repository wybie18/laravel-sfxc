<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * ActivityLog Model
 *
 * Represents an activity log entry.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $action
 * @property string|null $loggable_type
 * @property int|null $loggable_id
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property Carbon $performed_at
 *
 * @property-read User|null $user
 * @property-read Model|null $loggable
 */
final class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'loggable_type',
        'loggable_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'performed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'old_values' => 'json',
            'new_values' => 'json',
            'performed_at' => 'datetime',
        ];
    }

    /**
     * Get the user who performed the action.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loggable model (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
