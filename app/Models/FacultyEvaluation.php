<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * FacultyEvaluation Model
 *
 * Represents an evaluation of a faculty member.
 *
 * @property int $id
 * @property int $evaluation_period_id
 * @property int $faculty_id
 * @property int $class_section_id
 * @property int $evaluated_by
 * @property string $evaluator_type
 * @property Carbon $evaluated_at
 * @property string|null $overall_comment
 * @property bool $is_anonymous
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read EvaluationPeriod $evaluationPeriod
 * @property-read Faculty $faculty
 * @property-read ClassSection $classSection
 * @property-read User $evaluator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, EvaluationResponse> $responses
 */
final class FacultyEvaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'evaluation_period_id',
        'faculty_id',
        'class_section_id',
        'evaluated_by',
        'evaluator_type',
        'evaluated_at',
        'overall_comment',
        'is_anonymous',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'evaluated_at' => 'datetime',
            'is_anonymous' => 'boolean',
        ];
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
     * Get the faculty being evaluated.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
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
     * Get the evaluator.
     *
     * @return BelongsTo<User, $this>
     */
    public function evaluator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    /**
     * Get the responses.
     *
     * @return HasMany<EvaluationResponse, $this>
     */
    public function responses(): HasMany
    {
        return $this->hasMany(EvaluationResponse::class);
    }
}
