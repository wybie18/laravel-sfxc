<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * NewsPost Model
 *
 * Represents a news post or announcement.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $summary
 * @property string $content
 * @property string|null $featured_image
 * @property int|null $category_id
 * @property int $author_id
 * @property string $publish_status
 * @property Carbon|null $published_at
 * @property bool $is_featured
 * @property bool $is_pinned
 * @property int $view_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read NewsCategory|null $category
 * @property-read User $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, NewsAttachment> $attachments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, NewsAudience> $audiences
 */
final class NewsPost extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'publish_status',
        'published_at',
        'is_featured',
        'is_pinned',
        'view_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_pinned' => 'boolean',
            'view_count' => 'integer',
        ];
    }

    /**
     * Get the category.
     *
     * @return BelongsTo<NewsCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class);
    }

    /**
     * Get the author.
     *
     * @return BelongsTo<User, $this>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the attachments.
     *
     * @return HasMany<NewsAttachment, $this>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(NewsAttachment::class);
    }

    /**
     * Get the audiences.
     *
     * @return HasMany<NewsAudience, $this>
     */
    public function audiences(): HasMany
    {
        return $this->hasMany(NewsAudience::class);
    }

    /**
     * Get the user interactions.
     *
     * @return HasMany<UserNewsInteraction, $this>
     */
    public function interactions(): HasMany
    {
        return $this->hasMany(UserNewsInteraction::class);
    }

    /**
     * Check if the post is published.
     */
    public function isPublished(): bool
    {
        return $this->publish_status === 'published';
    }

    /**
     * Increment the view count.
     */
    public function incrementViews(): void
    {
        $this->increment('view_count');
    }
}
