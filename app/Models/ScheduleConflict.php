<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ScheduleConflict Model
 *
 * Represents a schedule conflict.
 *
 * @property int $id
 * @property int $schedule_assignment_id
 * @property int $conflicting_assignment_id
 * @property string $conflict_type
 * @property string|null $description
 * @property string $status
 * @property int|null $resolved_by
 * @property Carbon|null $resolved_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ScheduleAssignment $scheduleAssignment
 * @property-read ScheduleAssignment $conflictingAssignment
 * @property-read User|null $resolver
 */
final class ScheduleConflict extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'schedule_assignment_id',
        'conflicting_assignment_id',
        'conflict_type',
        'description',
        'status',
        'resolved_by',
        'resolved_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
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
     * Get the conflicting schedule assignment.
     *
     * @return BelongsTo<ScheduleAssignment, $this>
     */
    public function conflictingAssignment(): BelongsTo
    {
        return $this->belongsTo(ScheduleAssignment::class, 'conflicting_assignment_id');
    }

    /**
     * Get the resolver.
     *
     * @return BelongsTo<User, $this>
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Check if the conflict is resolved.
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }
}
