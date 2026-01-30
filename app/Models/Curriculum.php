<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Curriculum Model
 *
 * Represents a subject within a program's curriculum.
 *
 * @property int $id
 * @property int $program_id
 * @property int $subject_id
 * @property int $year_level
 * @property int $semester
 * @property bool $is_required
 * @property int $effective_academic_year_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Program $program
 * @property-read Subject $subject
 * @property-read AcademicYear $effectiveAcademicYear
 */
final class Curriculum extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'curriculum';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'program_id',
        'subject_id',
        'year_level',
        'semester',
        'is_required',
        'effective_academic_year_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year_level' => 'integer',
            'semester' => 'integer',
            'is_required' => 'boolean',
        ];
    }

    /**
     * Get the program this curriculum belongs to.
     *
     * @return BelongsTo<Program, $this>
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the subject in this curriculum entry.
     *
     * @return BelongsTo<Subject, $this>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the effective academic year.
     *
     * @return BelongsTo<AcademicYear, $this>
     */
    public function effectiveAcademicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'effective_academic_year_id');
    }
}
