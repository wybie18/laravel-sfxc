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
 * Subject Model
 *
 * Represents an academic subject or course.
 *
 * @property int $id
 * @property string $subject_code
 * @property string $subject_name
 * @property string|null $description
 * @property float $units
 * @property float $lecture_hours
 * @property float $lab_hours
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Curriculum> $curriculum
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClassSection> $classSections
 * @property-read \Illuminate\Database\Eloquent\Collection<int, SubjectPrerequisite> $prerequisites
 */
final class Subject extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'subject_code',
        'subject_name',
        'description',
        'units',
        'lecture_hours',
        'lab_hours',
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
            'units' => 'decimal:1',
            'lecture_hours' => 'decimal:1',
            'lab_hours' => 'decimal:1',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the curriculum entries for this subject.
     *
     * @return HasMany<Curriculum, $this>
     */
    public function curriculum(): HasMany
    {
        return $this->hasMany(Curriculum::class);
    }

    /**
     * Get the class sections for this subject.
     *
     * @return HasMany<ClassSection, $this>
     */
    public function classSections(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }

    /**
     * Get the prerequisites for this subject.
     *
     * @return HasMany<SubjectPrerequisite, $this>
     */
    public function prerequisites(): HasMany
    {
        return $this->hasMany(SubjectPrerequisite::class);
    }

    /**
     * Get the subjects that have this as a prerequisite.
     *
     * @return HasMany<SubjectPrerequisite, $this>
     */
    public function prerequisiteFor(): HasMany
    {
        return $this->hasMany(SubjectPrerequisite::class, 'prerequisite_subject_id');
    }

    /**
     * Get the total hours (lecture + lab).
     */
    public function getTotalHoursAttribute(): float
    {
        return $this->lecture_hours + $this->lab_hours;
    }
}
