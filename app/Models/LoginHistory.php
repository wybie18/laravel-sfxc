<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * LoginHistory Model
 *
 * Represents a login history entry.
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $login_status
 * @property string|null $failure_reason
 * @property Carbon $login_at
 * @property Carbon|null $logout_at
 *
 * @property-read User $user
 */
final class LoginHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'login_history';

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
        'ip_address',
        'user_agent',
        'login_status',
        'failure_reason',
        'login_at',
        'logout_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'login_at' => 'datetime',
            'logout_at' => 'datetime',
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
}
