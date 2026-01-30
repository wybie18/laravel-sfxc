<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Enrollment Model
 *
 * Represents a student's enrollment for a specific semester.
 *
 * @property int $id
 * @property int $student_id
 * @property int $semester_id
 * @property int $student_program_id
 * @property Carbon $enrollment_date
 * @property string $enrollment_status
 * @property int $year_level
 * @property float $total_units
 * @property int|null $approved_by
 * @property Carbon|null $approved_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Student $student
 * @property-read Semester $semester
 * @property-read StudentProgram $studentProgram
 * @property-read User|null $approver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentClassEnrollment> $classEnrollments
 */
final class Enrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'semester_id',
        'student_program_id',
        'enrollment_date',
        'enrollment_status',
        'year_level',
        'total_units',
        'approved_by',
        'approved_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'enrollment_date' => 'datetime',
            'year_level' => 'integer',
            'total_units' => 'decimal:1',
            'approved_at' => 'datetime',
        ];
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
     * Get the semester.
     *
     * @return BelongsTo<Semester, $this>
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the student program.
     *
     * @return BelongsTo<StudentProgram, $this>
     */
    public function studentProgram(): BelongsTo
    {
        return $this->belongsTo(StudentProgram::class);
    }

    /**
     * Get the user who approved this enrollment.
     *
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the class enrollments.
     *
     * @return HasMany<StudentClassEnrollment, $this>
     */
    public function classEnrollments(): HasMany
    {
        return $this->hasMany(StudentClassEnrollment::class);
    }

    /**
     * Get the enrollment fees.
     *
     * @return HasMany<EnrollmentFee, $this>
     */
    public function fees(): HasMany
    {
        return $this->hasMany(EnrollmentFee::class);
    }

    /**
     * Get the student GPA for this enrollment.
     *
     * @return HasOne<StudentGpa, $this>
     */
    public function gpa(): HasOne
    {
        return $this->hasOne(StudentGpa::class);
    }

    /**
     * Check if the enrollment is approved.
     */
    public function isApproved(): bool
    {
        return $this->enrollment_status === 'approved' || $this->enrollment_status === 'enrolled';
    }
}
