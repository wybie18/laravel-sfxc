<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * EvaluationPeriod Model
 *
 * Represents an evaluation period.
 *
 * @property int $id
 * @property int $semester_id
 * @property string $period_name
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property string $evaluation_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Semester $semester
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FacultyEvaluation> $evaluations
 */
final class EvaluationPeriod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'semester_id',
        'period_name',
        'start_date',
        'end_date',
        'evaluation_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    /**
     * Get the semester.
     *
     * @return BelongsTo<Semester, $this>
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the evaluations in this period.
     *
     * @return HasMany<FacultyEvaluation, $this>
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(FacultyEvaluation::class);
    }

    /**
     * Check if the period is currently active.
     */
    public function isActive(): bool
    {
        return $this->evaluation_status === 'open';
    }
}
