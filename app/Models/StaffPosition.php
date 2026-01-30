<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * StaffPosition Model
 *
 * Represents a staff position or job title.
 *
 * @property int $id
 * @property string $position_code
 * @property string $position_title
 * @property string $position_level
 * @property int|null $office_id
 * @property int|null $department_id
 * @property string|null $job_description
 * @property string|null $required_qualifications
 * @property string|null $salary_grade
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Office|null $office
 * @property-read Department|null $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Staff> $staff
 */
final class StaffPosition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'position_code',
        'position_title',
        'position_level',
        'office_id',
        'department_id',
        'job_description',
        'required_qualifications',
        'salary_grade',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the office this position belongs to.
     *
     * @return BelongsTo<Office, $this>
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }

    /**
     * Get the department this position belongs to.
     *
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the staff members with this position.
     *
     * @return HasMany<Staff, $this>
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }
}
