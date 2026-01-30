<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ScheduleChangeRequest Model
 *
 * Represents a request to change a schedule.
 *
 * @property int $id
 * @property int $schedule_assignment_id
 * @property int $requested_by
 * @property string $change_type
 * @property int|null $new_room_id
 * @property int|null $new_time_slot_id
 * @property int|null $new_day_of_week
 * @property string|null $reason
 * @property string $status
 * @property int|null $processed_by
 * @property Carbon|null $processed_at
 * @property string|null $rejection_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ScheduleAssignment $scheduleAssignment
 * @property-read User $requester
 * @property-read Room|null $newRoom
 * @property-read TimeSlot|null $newTimeSlot
 * @property-read User|null $processor
 */
final class ScheduleChangeRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'schedule_assignment_id',
        'requested_by',
        'change_type',
        'new_room_id',
        'new_time_slot_id',
        'new_day_of_week',
        'reason',
        'status',
        'processed_by',
        'processed_at',
        'rejection_reason',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'new_day_of_week' => 'integer',
            'processed_at' => 'datetime',
        ];
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

    /**
     * Get the requester.
     *
     * @return BelongsTo<User, $this>
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    /**
     * Get the new room.
     *
     * @return BelongsTo<Room, $this>
     */
    public function newRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'new_room_id');
    }

    /**
     * Get the new time slot.
     *
     * @return BelongsTo<TimeSlot, $this>
     */
    public function newTimeSlot(): BelongsTo
    {
        return $this->belongsTo(TimeSlot::class, 'new_time_slot_id');
    }

    /**
     * Get the processor.
     *
     * @return BelongsTo<User, $this>
     */
    public function processor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Check if the request is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
