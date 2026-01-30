<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * CourseOffering Model
 *
 * Represents a course offering for a section.
 *
 * @property int $id
 * @property int $program_section_id
 * @property int $semester_id
 * @property string $offering_code
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ProgramSection $programSection
 * @property-read Semester $semester
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CourseOfferingSubject> $subjects
 */
final class CourseOffering extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'program_section_id',
        'semester_id',
        'offering_code',
        'status',
    ];

    /**
     * Get the program section.
     *
     * @return BelongsTo<ProgramSection, $this>
     */
    public function programSection(): BelongsTo
    {
        return $this->belongsTo(ProgramSection::class);
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
     * Get the subjects in this offering.
     *
     * @return HasMany<CourseOfferingSubject, $this>
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(CourseOfferingSubject::class);
    }
}
