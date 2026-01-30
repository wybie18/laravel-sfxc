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
 * Program Model
 *
 * Represents an academic program or degree.
 *
 * @property int $id
 * @property int $department_id
 * @property string $program_code
 * @property string $program_name
 * @property string $program_type
 * @property string|null $degree_type
 * @property int $duration_years
 * @property int $total_units
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Curriculum> $curriculum
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentProgram> $studentPrograms
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Specialization> $specializations
 */
final class Program extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'department_id',
        'program_code',
        'program_name',
        'program_type',
        'degree_type',
        'duration_years',
        'total_units',
        'description',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'duration_years' => 'integer',
            'total_units' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the department this program belongs to.
     *
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the curriculum entries for this program.
     *
     * @return HasMany<Curriculum, $this>
     */
    public function curriculum(): HasMany
    {
        return $this->hasMany(Curriculum::class);
    }

    /**
     * Get the students enrolled in this program.
     *
     * @return HasMany<StudentProgram, $this>
     */
    public function studentPrograms(): HasMany
    {
        return $this->hasMany(StudentProgram::class);
    }

    /**
     * Get the program heads history.
     *
     * @return HasMany<ProgramHead, $this>
     */
    public function headHistory(): HasMany
    {
        return $this->hasMany(ProgramHead::class);
    }

    /**
     * Get the specializations for this program.
     *
     * @return HasMany<Specialization, $this>
     */
    public function specializations(): HasMany
    {
        return $this->hasMany(Specialization::class);
    }

    /**
     * Get the program sections.
     *
     * @return HasMany<ProgramSection, $this>
     */
    public function programSections(): HasMany
    {
        return $this->hasMany(ProgramSection::class);
    }

    /**
     * Get the course offerings.
     *
     * @return HasMany<CourseOffering, $this>
     */
    public function courseOfferings(): HasMany
    {
        return $this->hasMany(CourseOffering::class);
    }
}
