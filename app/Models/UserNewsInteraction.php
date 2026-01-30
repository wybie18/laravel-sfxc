<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * UserNewsInteraction Model
 *
 * Represents a user's interaction with a news post.
 *
 * @property int $id
 * @property int $user_id
 * @property int $news_post_id
 * @property string $interaction_type
 * @property Carbon $interacted_at
 *
 * @property-read User $user
 * @property-read NewsPost $newsPost
 */
final class UserNewsInteraction extends Model
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
        'news_post_id',
        'interaction_type',
        'interacted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'interacted_at' => 'datetime',
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
     * Get the news post.
     *
     * @return BelongsTo<NewsPost, $this>
     */
    public function newsPost(): BelongsTo
    {
        return $this->belongsTo(NewsPost::class);
    }
}
