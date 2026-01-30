<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * EvaluationSummary Model
 *
 * Represents a summary of evaluations for a faculty member.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $evaluation_period_id
 * @property int|null $class_section_id
 * @property int $total_evaluations
 * @property float $average_rating
 * @property float|null $category_averages
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read EvaluationPeriod $evaluationPeriod
 * @property-read ClassSection|null $classSection
 */
final class EvaluationSummary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'evaluation_period_id',
        'class_section_id',
        'total_evaluations',
        'average_rating',
        'category_averages',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_evaluations' => 'integer',
            'average_rating' => 'decimal:2',
            'category_averages' => 'json',
        ];
    }

    /**
     * Get the faculty.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the evaluation period.
     *
     * @return BelongsTo<EvaluationPeriod, $this>
     */
    public function evaluationPeriod(): BelongsTo
    {
        return $this->belongsTo(EvaluationPeriod::class);
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
}
