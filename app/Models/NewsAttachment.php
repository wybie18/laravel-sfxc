<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * NewsAttachment Model
 *
 * Represents an attachment for a news post.
 *
 * @property int $id
 * @property int $news_post_id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_type
 * @property int $file_size
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read NewsPost $newsPost
 */
final class NewsAttachment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'news_post_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
        ];
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
