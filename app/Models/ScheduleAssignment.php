<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ScheduleAssignment Model
 *
 * Represents a schedule assignment for a course.
 *
 * @property int $id
 * @property int $course_offering_subject_id
 * @property int $faculty_id
 * @property int $room_id
 * @property int $time_slot_id
 * @property int $day_of_week
 * @property string $schedule_type
 * @property string $status
 * @property Carbon|null $effective_date
 * @property Carbon|null $end_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read CourseOfferingSubject $courseOfferingSubject
 * @property-read Faculty $faculty
 * @property-read Room $room
 * @property-read TimeSlot $timeSlot
 */
final class ScheduleAssignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'course_offering_subject_id',
        'faculty_id',
        'room_id',
        'time_slot_id',
        'day_of_week',
        'schedule_type',
        'status',
        'effective_date',
        'end_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'effective_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Get the course offering subject.
     *
     * @return BelongsTo<CourseOfferingSubject, $this>
     */
    public function courseOfferingSubject(): BelongsTo
    {
        return $this->belongsTo(CourseOfferingSubject::class);
    }

    /**
     * Get the faculty member.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * Get the room.
     *
     * @return BelongsTo<Room, $this>
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the time slot.
     *
     * @return BelongsTo<TimeSlot, $this>
     */
    public function timeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class);
    }

    /**
     * Get the conflicts.
     *
     * @return HasMany<ScheduleConflict, $this>
     */
    public function conflicts(): HasMany
    {
        return $this->hasMany(ScheduleConflict::class);
    }

    /**
     * Get the conflicting assignments.
     *
     * @return HasMany<ScheduleConflict, $this>
     */
    public function conflictingWith(): HasMany
    {
        return $this->hasMany(ScheduleConflict::class, 'conflicting_assignment_id');
    }

    /**
     * Get the day name.
     */
    public function getDayNameAttribute(): string
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        return $days[$this->day_of_week] ?? '';
    }
}
