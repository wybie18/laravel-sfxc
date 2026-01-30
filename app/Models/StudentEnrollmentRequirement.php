<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * StudentEnrollmentRequirement Model
 *
 * Represents a student's compliance with an enrollment requirement.
 *
 * @property int $id
 * @property int $student_id
 * @property int $requirement_id
 * @property int $enrollment_id
 * @property string $status
 * @property string|null $file_path
 * @property Carbon|null $submitted_at
 * @property int|null $verified_by
 * @property Carbon|null $verified_at
 * @property string|null $remarks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Student $student
 * @property-read EnrollmentRequirement $requirement
 * @property-read Enrollment $enrollment
 * @property-read Staff|null $verifier
 */
final class StudentEnrollmentRequirement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'requirement_id',
        'enrollment_id',
        'status',
        'file_path',
        'submitted_at',
        'verified_by',
        'verified_at',
        'remarks',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'verified_at' => 'datetime',
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
     * Get the requirement.
     *
     * @return BelongsTo<EnrollmentRequirement, $this>
     */
    public function requirement(): BelongsTo
    {
        return $this->belongsTo(EnrollmentRequirement::class, 'requirement_id');
    }

    /**
     * Get the enrollment.
     *
     * @return BelongsTo<Enrollment, $this>
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Get the verifier.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'verified_by');
    }

    /**
     * Check if the requirement is verified.
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }
}
