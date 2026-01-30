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
 * Department Model
 *
 * Represents an academic department within a college.
 *
 * @property int $id
 * @property string $department_code
 * @property string $department_name
 * @property string|null $description
 * @property int|null $head_faculty_id
 * @property int $college_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read College $college
 * @property-read Faculty|null $head
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Program> $programs
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Faculty> $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Staff> $staff
 */
final class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'department_code',
        'department_name',
        'description',
        'head_faculty_id',
        'college_id',
    ];

    /**
     * Get the college this department belongs to.
     *
     * @return BelongsTo<College, $this>
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    /**
     * Get the head of this department.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'head_faculty_id');
    }

    /**
     * Get the programs under this department.
     *
     * @return HasMany<Program, $this>
     */
    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }

    /**
     * Get the faculty members in this department.
     *
     * @return HasMany<Faculty, $this>
     */
    public function faculty(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    /**
     * Get the staff members in this department.
     *
     * @return HasMany<Staff, $this>
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Get the department head history.
     *
     * @return HasMany<DepartmentHead, $this>
     */
    public function headHistory(): HasMany
    {
        return $this->hasMany(DepartmentHead::class);
    }

    /**
     * Get the buildings associated with this department.
     *
     * @return HasMany<Building, $this>
     */
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }
}
