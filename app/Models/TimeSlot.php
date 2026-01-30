<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * TimeSlot Model
 *
 * Represents a time slot for scheduling.
 *
 * @property int $id
 * @property string $name
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property int $duration_minutes
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, FacultyAvailability> $facultyAvailabilities
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ScheduleAssignment> $scheduleAssignments
 */
final class TimeSlot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'duration_minutes',
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
            'start_time' => 'datetime:H:i:s',
            'end_time' => 'datetime:H:i:s',
            'duration_minutes' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the faculty availabilities.
     *
     * @return HasMany<FacultyAvailability, $this>
     */
    public function facultyAvailabilities(): HasMany
    {
        return $this->hasMany(FacultyAvailability::class);
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
