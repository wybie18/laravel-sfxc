<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ClassSection Model
 *
 * Represents a class section for a subject in a semester.
 *
 * @property int $id
 * @property int $subject_id
 * @property int $semester_id
 * @property string $section_name
 * @property int|null $faculty_id
 * @property string|null $room
 * @property string|null $schedule_days
 * @property string|null $schedule_time_start
 * @property string|null $schedule_time_end
 * @property int $max_students
 * @property int $current_enrolled
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Subject $subject
 * @property-read Semester $semester
 * @property-read Faculty|null $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentClassEnrollment> $studentEnrollments
 */
final class ClassSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'subject_id',
        'semester_id',
        'section_name',
        'faculty_id',
        'room',
        'schedule_days',
        'schedule_time_start',
        'schedule_time_end',
        'max_students',
        'current_enrolled',
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
            'max_students' => 'integer',
            'current_enrolled' => 'integer',
            'schedule_time_start' => 'datetime:H:i',
            'schedule_time_end' => 'datetime:H:i',
        ];
    }

    /**
     * Get the subject for this section.
     *
     * @return BelongsTo<Subject, $this>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the semester for this section.
     *
     * @return BelongsTo<Semester, $this>
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Get the faculty teaching this section.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the student enrollments in this section.
     *
     * @return HasMany<StudentClassEnrollment, $this>
     */
    public function studentEnrollments(): HasMany
    {
        return $this->hasMany(StudentClassEnrollment::class);
    }

    /**
     * Get the grading structures for this section.
     *
     * @return HasMany<ClassGradingStructure, $this>
     */
    public function gradingStructures(): HasMany
    {
        return $this->hasMany(ClassGradingStructure::class);
    }

    /**
     * Check if the section is full.
     */
    public function isFull(): bool
    {
        return $this->current_enrolled >= $this->max_students;
    }

    /**
     * Check if the section is open for enrollment.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open' && ! $this->isFull();
    }

    /**
     * Get the available slots.
     */
    public function getAvailableSlotsAttribute(): int
    {
        return max(0, $this->max_students - $this->current_enrolled);
    }
}
