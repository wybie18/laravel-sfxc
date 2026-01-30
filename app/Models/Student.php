<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * Student Model
 *
 * Represents a student enrolled in the institution.
 *
 * @property int $id
 * @property int $user_id
 * @property string $student_number
 * @property Carbon $admission_date
 * @property string $student_type
 * @property string $student_status
 * @property int|null $current_year_level
 * @property string|null $scholarship_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentGuardian> $guardians
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentProgram> $studentPrograms
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Enrollment> $enrollments
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Candidate> $candidacies
 */
final class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'student_number',
        'admission_date',
        'student_type',
        'student_status',
        'current_year_level',
        'scholarship_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'current_year_level' => 'integer',
        ];
    }

    /**
     * Get the user that owns this student record.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the guardians for this student.
     *
     * @return HasMany<StudentGuardian, $this>
     */
    public function guardians(): HasMany
    {
        return $this->hasMany(StudentGuardian::class);
    }

    /**
     * Get the primary guardian for this student.
     *
     * @return HasOne<StudentGuardian, $this>
     */
    public function primaryGuardian(): HasOne
    {
        return $this->hasOne(StudentGuardian::class)->where('is_primary', true);
    }

    /**
     * Get the student program enrollments.
     *
     * @return HasMany<StudentProgram, $this>
     */
    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class);
    }

    /**
     * Get the current active student program.
     *
     * @return HasOne<StudentProgram, $this>
     */
    public function currentProgram(): HasOne
    {
        return $this->hasOne(StudentProgram::class)
            ->where('status', 'active')
            ->latestOfMany();
    }

    /**
     * Get the enrollment records for this student.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the candidacies for this student.
     *
     * @return HasMany<Candidate, $this>
     */
    public function candidacies(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get the clearance requests for this student.
     *
     * @return HasMany<ClearanceRequest, $this>
     */
    public function clearanceRequests(): HasMany
    {
        return $this->hasMany(ClearanceRequest::class);
    }

    /**
     * Check if the student is currently enrolled.
     */
    public function isEnrolled(): bool
    {
        return $this->student_status === 'active';
    }

    /**
     * Check if the student has graduated.
     */
    public function hasGraduated(): bool
    {
        return $this->student_status === 'graduated';
    }
}
