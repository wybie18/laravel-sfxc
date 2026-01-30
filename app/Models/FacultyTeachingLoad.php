<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * FacultyTeachingLoad Model
 *
 * Represents a faculty member's teaching load per subject.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $schedule_assignment_id
 * @property float $teaching_units
 * @property float $preparation_hours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read ScheduleAssignment $scheduleAssignment
 */
final class FacultyTeachingLoad extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'schedule_assignment_id',
        'teaching_units',
        'preparation_hours',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'teaching_units' => 'decimal:2',
            'preparation_hours' => 'decimal:2',
        ];
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
     * Get the schedule assignment.
     *
     * @return BelongsTo<ScheduleAssignment, $this>
     */
    public function scheduleAssignment(): BelongsTo
    {
        return $this->belongsTo(ScheduleAssignment::class);
    }
}
