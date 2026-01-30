<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * EvaluationCategory Model
 *
 * Represents a category for evaluation criteria.
 *
 * @property int $id
 * @property string $category_name
 * @property string|null $description
 * @property float $weight_percentage
 * @property int $sequence_order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EvaluationCriterion> $criteria
 */
final class EvaluationCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_name',
        'description',
        'weight_percentage',
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
            'weight_percentage' => 'decimal:2',
            'sequence_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the criteria in this category.
     *
     * @return HasMany<EvaluationCriterion, $this>
     */
    public function criteria(): HasMany
    {
        return $this->hasMany(EvaluationCriterion::class);
    }
}
