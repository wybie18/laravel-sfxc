<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * NewsCategory Model
 *
 * Represents a category for news posts.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $color
 * @property int $sequence_order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, NewsPost> $posts
 */
final class NewsCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'sequence_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sequence_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the news posts in this category.
     *
     * @return HasMany<NewsPost, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(NewsPost::class, 'category_id');
    }
}
