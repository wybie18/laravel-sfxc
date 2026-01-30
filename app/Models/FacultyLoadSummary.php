<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * FacultyLoadSummary Model
 *
 * Represents a summary of a faculty member's total load.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $semester_id
 * @property float $total_teaching_units
 * @property float $total_admin_units
 * @property float $total_research_units
 * @property float $total_units
 * @property string $load_status
 * @property Carbon $computed_at
 *
 * @property-read Faculty $faculty
 * @property-read Semester $semester
 */
final class FacultyLoadSummary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'faculty_load_summaries';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'semester_id',
        'total_teaching_units',
        'total_admin_units',
        'total_research_units',
        'total_units',
        'load_status',
        'computed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_teaching_units' => 'decimal:2',
            'total_admin_units' => 'decimal:2',
            'total_research_units' => 'decimal:2',
            'total_units' => 'decimal:2',
            'computed_at' => 'datetime',
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

    /**
     * Check if the load is overloaded.
     */
    public function isOverloaded(): bool
    {
        return $this->load_status === 'overload';
    }

    /**
     * Check if the load is underloaded.
     */
    public function isUnderloaded(): bool
    {
        return $this->load_status === 'underload';
    }
}
