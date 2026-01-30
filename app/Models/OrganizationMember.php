<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * OrganizationMember Model
 *
 * Represents a member of a student organization.
 *
 * @property int $id
 * @property int $organization_id
 * @property int $student_id
 * @property int $academic_year_id
 * @property string $membership_type
 * @property string $status
 * @property Carbon $joined_at
 * @property Carbon|null $left_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentOrganization $organization
 * @property-read Student $student
 * @property-read AcademicYear $academicYear
 */
final class OrganizationMember extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'student_id',
        'academic_year_id',
        'membership_type',
        'status',
        'joined_at',
        'left_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'joined_at' => 'date',
            'left_at' => 'date',
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
}
