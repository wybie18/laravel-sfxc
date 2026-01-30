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
 * Room Model
 *
 * Represents a room in a building.
 *
 * @property int $id
 * @property int $building_id
 * @property int $room_type_id
 * @property string $code
 * @property string $name
 * @property int $floor
 * @property int $capacity
 * @property array|null $equipment
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Building $building
 * @property-read RoomType $roomType
 */
final class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'building_id',
        'room_type_id',
        'code',
        'name',
        'floor',
        'capacity',
        'equipment',
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
            'floor' => 'integer',
            'capacity' => 'integer',
            'equipment' => 'json',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the building.
     *
     * @return BelongsTo<Building, $this>
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get the room type.
     *
     * @return BelongsTo<RoomType, $this>
     */
    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class);
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

    /**
     * Get the room reservations.
     *
     * @return HasMany<RoomReservation, $this>
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(RoomReservation::class);
    }

    /**
     * Get the full room name with building.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->building->code} - {$this->name}";
    }
}
