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
 * College Model
 *
 * Represents an academic college within the institution.
 *
 * @property int $id
 * @property string $college_code
 * @property string $college_name
 * @property string $acronym
 * @property string|null $description
 * @property int|null $dean_faculty_id
 * @property Carbon|null $established_date
 * @property string|null $building_location
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Faculty|null $dean
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Department> $departments
 */
final class College extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'college_code',
        'college_name',
        'acronym',
        'description',
        'dean_faculty_id',
        'established_date',
        'building_location',
        'contact_email',
        'contact_phone',
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
            'established_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the dean of this college.
     *
     * @return BelongsTo<Faculty, $this>
     */
    public function dean(): BelongsTo
    {
        return $this->belongsTo(Faculty::class, 'dean_faculty_id');
    }

    /**
     * Get the departments under this college.
     *
     * @return HasMany<Department, $this>
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * Get the college deans history.
     *
     * @return HasMany<CollegeDean, $this>
     */
    public function deanHistory(): HasMany
    {
        return $this->hasMany(CollegeDean::class);
    }
}
