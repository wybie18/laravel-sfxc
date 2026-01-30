<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * CourseOfferingSubject Model
 *
 * Represents a subject in a course offering.
 *
 * @property int $id
 * @property int $course_offering_id
 * @property int $subject_id
 * @property bool $is_required
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read CourseOffering $courseOffering
 * @property-read Subject $subject
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ScheduleAssignment> $scheduleAssignments
 */
final class CourseOfferingSubject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_offering_id',
        'subject_id',
        'is_required',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    /**
     * Get the course offering.
     *
     * @return BelongsTo<CourseOffering, $this>
     */
    public function courseOffering(): BelongsTo
    {
        return $this->belongsTo(CourseOffering::class);
    }

    /**
     * Get the subject.
     *
     * @return BelongsTo<Subject, $this>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
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
}
