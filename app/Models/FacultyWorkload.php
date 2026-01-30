<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * FacultyWorkload Model
 *
 * Represents the workload configuration for a faculty member.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $semester_id
 * @property float $min_units
 * @property float $max_units
 * @property float $preferred_units
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Semester $semester
 */
final class FacultyWorkload extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'semester_id',
        'min_units',
        'max_units',
        'preferred_units',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'min_units' => 'decimal:2',
            'max_units' => 'decimal:2',
            'preferred_units' => 'decimal:2',
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
     * Get the semester.
     *
     * @return BelongsTo<Semester, $this>
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }
}
