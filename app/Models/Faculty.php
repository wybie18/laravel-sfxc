<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Faculty Model
 *
 * Represents a teaching faculty member.
 *
 * @property int $id
 * @property int $user_id
 * @property string $employee_number
 * @property int $department_id
 * @property string $employment_type
 * @property string $faculty_rank
 * @property string|null $specialization
 * @property Carbon $hire_date
 * @property string $employment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClassSection> $classSections
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FacultyPosition> $positions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FacultyEvaluation> $evaluations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Specialization> $specializations
 */
final class Faculty extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'faculty';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'employee_number',
        'department_id',
        'employment_type',
        'faculty_rank',
        'specialization',
        'hire_date',
        'employment_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    /**
     * Get the user this faculty record belongs to.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the department this faculty member belongs to.
     *
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the class sections taught by this faculty.
     *
     * @return HasMany<ClassSection, $this>
     */
    public function classSections(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }

    /**
     * Get the faculty positions.
     *
     * @return HasMany<FacultyPosition, $this>
     */
    public function positions(): HasMany
    {
        return $this->hasMany(FacultyPosition::class);
    }

    /**
     * Get the workload assignments.
     *
     * @return HasMany<FacultyWorkload, $this>
     */
    public function workloads(): HasMany
    {
        return $this->hasMany(FacultyWorkload::class);
    }

    /**
     * Get the faculty evaluations.
     *
     * @return HasMany<FacultyEvaluation, $this>
     */
    public function evaluations(): HasMany
    {
        return $this->hasMany(FacultyEvaluation::class);
    }

    /**
     * Get the specializations.
     *
     * @return BelongsToMany<Specialization, $this>
     */
    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'faculty_specializations')
            ->withPivot('is_primary')
            ->withTimestamps();
    }

    /**
     * Get the faculty availabilities.
     *
     * @return HasMany<FacultyAvailability, $this>
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(FacultyAvailability::class);
    }

    /**
     * Get the administrative loads.
     *
     * @return HasMany<AdministrativeLoad, $this>
     */
    public function administrativeLoads(): HasMany
    {
        return $this->hasMany(AdministrativeLoad::class);
    }

    /**
     * Get the research loads.
     *
     * @return HasMany<ResearchLoad, $this>
     */
    public function researchLoads(): HasMany
    {
        return $this->hasMany(ResearchLoad::class);
    }

    /**
     * Get the teaching loads.
     *
     * @return HasMany<FacultyTeachingLoad, $this>
     */
    public function teachingLoads(): HasMany
    {
        return $this->hasMany(FacultyTeachingLoad::class);
    }

    /**
     * Get the load summaries.
     *
     * @return HasMany<FacultyLoadSummary, $this>
     */
    public function loadSummaries(): HasMany
    {
        return $this->hasMany(FacultyLoadSummary::class);
    }

    /**
     * Get the schedule assignments.
     *
     * @return HasMany<ScheduleAssignment, $this>
     */
    public function scheduleAssignments(): HasMany
    {
        return $this->hasMany(ScheduleAssignment::class);
    }

    /**
     * Check if the faculty member is currently active.
     */
    public function isActive(): bool
    {
        return $this->employment_status === 'active';
    }
}
