<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * RoomReservation Model
 *
 * Represents a room reservation.
 *
 * @property int $id
 * @property int $room_id
 * @property int $reserved_by
 * @property string $purpose
 * @property Carbon $reservation_date
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property string $status
 * @property int|null $approved_by
 * @property Carbon|null $approved_at
 * @property string|null $rejection_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Room $room
 * @property-read User $reserver
 * @property-read User|null $approver
 */
final class RoomReservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'room_id',
        'reserved_by',
        'purpose',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'approved_by',
        'approved_at',
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
            'reservation_date' => 'date',
            'start_time' => 'datetime:H:i:s',
            'end_time' => 'datetime:H:i:s',
            'approved_at' => 'datetime',
        ];
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
     * Get the user who reserved the room.
     *
     * @return BelongsTo<User, $this>
     */
    public function reserver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reserved_by');
    }

    /**
     * Get the approver.
     *
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Check if the reservation is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the reservation is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}
