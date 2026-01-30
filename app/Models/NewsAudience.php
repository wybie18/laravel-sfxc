<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * NewsAudience Model
 *
 * Represents target audiences for a news post.
 *
 * @property int $id
 * @property int $news_post_id
 * @property string $audience_type
 * @property int|null $audience_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read NewsPost $newsPost
 * @property-read Model|null $audience
 */
final class NewsAudience extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'news_post_id',
        'audience_type',
        'audience_id',
    ];

    /**
     * Get the news post.
     *
     * @return BelongsTo<NewsPost, $this>
     */
    public function newsPost(): BelongsTo
    {
        return $this->belongsTo(NewsPost::class);
    }

    /**
     * Get the audience (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function audience(): MorphTo
    {
        return $this->morphTo();
    }
}
