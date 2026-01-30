<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Staff Model
 *
 * Represents a non-teaching staff member.
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $office_id
 * @property string $employee_number
 * @property int $department_id
 * @property int|null $staff_position_id
 * @property string $staff_level
 * @property string $employment_type
 * @property int|null $reports_to_staff_id
 * @property Carbon $hire_date
 * @property string $employment_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read Office|null $office
 * @property-read Department $department
 * @property-read StaffPosition|null $position
 * @property-read Staff|null $supervisor
 */
final class Staff extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'staff';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'office_id',
        'employee_number',
        'department_id',
        'staff_position_id',
        'staff_level',
        'employment_type',
        'reports_to_staff_id',
        'hire_date',
        'employment_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hire_date' => 'date',
        ];
    }

    /**
     * Get the user this staff record belongs to.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the office this staff member works in.
     *
     * @return BelongsTo<Office, $this>
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the department this staff member belongs to.
     *
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position of this staff member.
     *
     * @return BelongsTo<StaffPosition, $this>
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(StaffPosition::class, 'staff_position_id');
    }

    /**
     * Get the supervisor of this staff member.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'reports_to_staff_id');
    }

    /**
     * Check if the staff member is currently active.
     */
    public function isActive(): bool
    {
        return $this->employment_status === 'active';
    }
}
