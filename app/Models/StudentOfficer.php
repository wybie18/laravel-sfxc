<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * StudentOfficer Model
 *
 * Represents a student holding an officer position.
 *
 * @property int $id
 * @property int $organization_id
 * @property int $position_id
 * @property int $student_id
 * @property int $academic_year_id
 * @property int $semester_id
 * @property Carbon|null $term_start
 * @property Carbon|null $term_end
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentOrganization $organization
 * @property-read OfficerPosition $position
 * @property-read Student $student
 * @property-read AcademicYear $academicYear
 * @property-read Semester $semester
 */
final class StudentOfficer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'position_id',
        'student_id',
        'academic_year_id',
        'semester_id',
        'term_start',
        'term_end',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'term_start' => 'date',
            'term_end' => 'date',
        ];
    }

    /**
     * Get the organization.
     *
     * @return BelongsTo<StudentOrganization, $this>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(StudentOrganization::class, 'organization_id');
    }

    /**
     * Get the position.
     *
     * @return BelongsTo<OfficerPosition, $this>
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(OfficerPosition::class, 'position_id');
    }

    /**
     * Get the student.
     *
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic year.
     *
     * @return BelongsTo<AcademicYear, $this>
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
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
     * Get the endorsements given.
     *
     * @return HasMany<CandidateEndorsement, $this>
     */
    public function endorsements(): HasMany
    {
        return $this->hasMany(CandidateEndorsement::class, 'endorsed_by');
    }
}
