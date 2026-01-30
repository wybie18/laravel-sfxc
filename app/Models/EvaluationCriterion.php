<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * EvaluationCriterion Model
 *
 * Represents an evaluation criterion within a category.
 *
 * @property int $id
 * @property int $category_id
 * @property string $criterion_text
 * @property int $max_rating
 * @property int $sequence_order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read EvaluationCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EvaluationResponse> $responses
 */
final class EvaluationCriterion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'evaluation_criteria';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'criterion_text',
        'max_rating',
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
            'max_rating' => 'integer',
            'sequence_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the category.
     *
     * @return BelongsTo<EvaluationCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(EvaluationCategory::class, 'category_id');
    }

    /**
     * Get the responses for this criterion.
     *
     * @return HasMany<EvaluationResponse, $this>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(EvaluationResponse::class, 'criterion_id');
    }
}
