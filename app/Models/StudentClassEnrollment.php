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
 * StudentClassEnrollment Model
 *
 * Represents a student's enrollment in a specific class section.
 *
 * @property int $id
 * @property int $enrollment_id
 * @property int $class_section_id
 * @property string $enrollment_type
 * @property Carbon $enrolled_at
 * @property Carbon|null $dropped_at
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Enrollment $enrollment
 * @property-read ClassSection $classSection
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Grade> $grades
 * @property-read FinalGrade|null $finalGrade
 */
final class StudentClassEnrollment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'enrollment_id',
        'class_section_id',
        'enrollment_type',
        'enrolled_at',
        'dropped_at',
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
            'enrolled_at' => 'datetime',
            'dropped_at' => 'datetime',
        ];
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
     * Get the class section.
     *
     * @return BelongsTo<ClassSection, $this>
     */
    public function classSection(): BelongsTo
    {
        return $this->belongsTo(ClassSection::class);
    }

    /**
     * Get the grades.
     *
     * @return HasMany<Grade, $this>
     */
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get the final grade.
     *
     * @return HasOne<FinalGrade, $this>
     */
    public function finalGrade(): HasOne
    {
        return $this->hasOne(FinalGrade::class);
    }

    /**
     * Check if the enrollment is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if the enrollment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
