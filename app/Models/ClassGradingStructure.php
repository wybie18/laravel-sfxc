<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ClassGradingStructure Model
 *
 * Represents the grading structure for a class section.
 *
 * @property int $id
 * @property int $class_section_id
 * @property int $grading_component_id
 * @property string $item_name
 * @property float $weight_percentage
 * @property float $max_score
 * @property string $grading_period
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ClassSection $classSection
 * @property-read GradingComponent $gradingComponent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Grade> $grades
 */
final class ClassGradingStructure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'class_section_id',
        'grading_component_id',
        'item_name',
        'weight_percentage',
        'max_score',
        'grading_period',
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
            'max_score' => 'decimal:2',
        ];
    }

    /**
     * Get the class section.
     *
     * @return BelongsTo<ClassSection, $this>
     */
    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class);
    }

    /**
     * Get the grading component.
     *
     * @return BelongsTo<GradingComponent, $this>
     */
    public function gradingComponent(): BelongsTo
    {
        return $this->belongsTo(GradingComponent::class);
    }

    /**
     * Get the grades for this grading structure.
     *
     * @return HasMany<Grade, $this>
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
