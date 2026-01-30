<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * AcademicYear Model
 *
 * Represents an academic year period (e.g., 2025-2026).
 *
 * @property int $id
 * @property string $year_code
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property bool $is_current
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Semester> $semesters
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Election> $elections
 */
final class AcademicYear extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'year_code',
        'start_date',
        'end_date',
        'is_current',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }

    /**
     * Get the semesters for this academic year.
     *
     * @return HasMany<Semester, $this>
     */
    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class);
    }

    /**
     * Get the elections held during this academic year.
     *
     * @return HasMany<Election, $this>
     */
    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

    /**
     * Get the curriculum records effective for this academic year.
     *
     * @return HasMany<Curriculum, $this>
     */
    public function effectiveCurriculum(): HasMany
    {
        return $this->hasMany(Curriculum::class, 'effective_academic_year_id');
    }

    /**
     * Get the current academic year.
     */
    public static function current(): ?self
    {
        return self::where('is_current', true)->first();
    }

    /**
     * Set this academic year as the current one.
     */
    public function setAsCurrent(): void
    {
        self::query()->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }
}
