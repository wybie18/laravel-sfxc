<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Semester Model
 *
 * Represents a semester within an academic year.
 *
 * @property int $id
 * @property int $academic_year_id
 * @property string $semester_name
 * @property string $semester_code
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property bool $is_current
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read AcademicYear $academicYear
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClassSection> $classSections
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Enrollment> $enrollments
 */
final class Semester extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'academic_year_id',
        'semester_name',
        'semester_code',
        'start_date',
        'end_date',
        'is_current',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }

    /**
     * Get the academic year this semester belongs to.
     *
     * @return BelongsTo<AcademicYear, $this>
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the class sections for this semester.
     *
     * @return HasMany<ClassSection, $this>
     */
    public function classSections(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }

    /**
     * Get the enrollments for this semester.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the evaluation periods for this semester.
     *
     * @return HasMany<EvaluationPeriod, $this>
     */
    public function evaluationPeriods(): HasMany
    {
        return $this->hasMany(EvaluationPeriod::class);
    }

    /**
     * Get the course offerings for this semester.
     *
     * @return HasMany<CourseOffering, $this>
     */
    public function courseOfferings(): HasMany
    {
        return $this->hasMany(CourseOffering::class);
    }

    /**
     * Get the current semester.
     */
    public static function current(): ?self
    {
        return self::where('is_current', true)->first();
    }

    /**
     * Set this semester as the current one.
     */
    public function setAsCurrent(): void
    {
        self::query()->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }

    /**
     * Get the full semester label (e.g., "First Semester 2025-2026").
     */
    public function getFullLabelAttribute(): string
    {
        return $this->semester_name . ' ' . $this->academicYear->year_code;
    }
}
