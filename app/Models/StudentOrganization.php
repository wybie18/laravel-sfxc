<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * StudentOrganization Model
 *
 * Represents a student organization.
 *
 * @property int $id
 * @property string $name
 * @property string $acronym
 * @property int $organization_type_id
 * @property int|null $college_id
 * @property int|null $department_id
 * @property int|null $program_id
 * @property string|null $description
 * @property string|null $logo_path
 * @property int|null $adviser_id
 * @property string $status
 * @property Carbon|null $established_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read OrganizationType $organizationType
 * @property-read College|null $college
 * @property-read Department|null $department
 * @property-read Program|null $program
 * @property-read Faculty|null $adviser
 */
final class StudentOrganization extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'acronym',
        'organization_type_id',
        'college_id',
        'department_id',
        'program_id',
        'description',
        'logo_path',
        'adviser_id',
        'status',
        'established_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'established_at' => 'date',
        ];
    }

    /**
     * Get the organization type.
     *
     * @return BelongsTo<OrganizationType, $this>
     */
    public function organizationType(): BelongsTo
    {
        return $this->belongsTo(OrganizationType::class);
    }

    /**
     * Get the college.
     *
     * @return BelongsTo<College, $this>
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get the department.
     *
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the program.
     *
     * @return BelongsTo<Program, $this>
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the adviser.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function adviser(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'adviser_id');
    }

    /**
     * Get the elections.
     *
     * @return HasMany<Election, $this>
     */
    public function elections(): HasMany
    {
        return $this->hasMany(Election::class, 'organization_id');
    }

    /**
     * Get the officer positions.
     *
     * @return HasMany<OfficerPosition, $this>
     */
    public function officerPositions(): HasMany
    {
        return $this->hasMany(OfficerPosition::class, 'organization_id');
    }

    /**
     * Get the members.
     *
     * @return HasMany<OrganizationMember, $this>
     */
    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class, 'organization_id');
    }

    /**
     * Get the activities.
     *
     * @return HasMany<OrganizationActivity, $this>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(OrganizationActivity::class, 'organization_id');
    }

    /**
     * Get the officers.
     *
     * @return HasMany<StudentOfficer, $this>
     */
    public function officers(): HasMany
    {
        return $this->hasMany(StudentOfficer::class, 'organization_id');
    }
}
