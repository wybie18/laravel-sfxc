<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * SchedulingPreference Model
 *
 * Represents a faculty member's scheduling preferences.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $semester_id
 * @property int|null $preferred_max_classes_per_day
 * @property int|null $preferred_max_consecutive_hours
 * @property array|null $preferred_days
 * @property array|null $avoided_days
 * @property string|null $special_requests
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Semester $semester
 */
final class SchedulingPreference extends Model
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
        'preferred_max_classes_per_day',
        'preferred_max_consecutive_hours',
        'preferred_days',
        'avoided_days',
        'special_requests',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'preferred_max_classes_per_day' => 'integer',
            'preferred_max_consecutive_hours' => 'integer',
            'preferred_days' => 'json',
            'avoided_days' => 'json',
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
