<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * EvaluationResponse Model
 *
 * Represents a response to an evaluation criterion.
 *
 * @property int $id
 * @property int $faculty_evaluation_id
 * @property int $criterion_id
 * @property int $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read FacultyEvaluation $facultyEvaluation
 * @property-read EvaluationCriterion $criterion
 */
final class EvaluationResponse extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_evaluation_id',
        'criterion_id',
        'rating',
        'comment',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    /**
     * Get the faculty evaluation.
     *
     * @return BelongsTo<FacultyEvaluation, $this>
     */
    public function facultyEvaluation(): BelongsTo
    {
        return $this->belongsTo(FacultyEvaluation::class);
    }

    /**
     * Get the criterion.
     *
     * @return BelongsTo<EvaluationCriterion, $this>
     */
    public function criterion(): BelongsTo
    {
        return $this->belongsTo(EvaluationCriterion::class);
    }
}
