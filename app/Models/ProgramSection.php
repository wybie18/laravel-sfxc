<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ProgramSection Model
 *
 * Represents a section of students in a program.
 *
 * @property int $id
 * @property int $program_id
 * @property int $semester_id
 * @property int $year_level
 * @property string $section_name
 * @property int|null $max_students
 * @property int|null $current_count
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Program $program
 * @property-read Semester $semester
 * @property-read \Illuminate\Database\Eloquent\Collection<int, CourseOffering> $courseOfferings
 */
final class ProgramSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'program_id',
        'semester_id',
        'year_level',
        'section_name',
        'max_students',
        'current_count',
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
            'max_students' => 'integer',
            'current_count' => 'integer',
        ];
    }

    /**
     * Get the program.
     *
     * @return BelongsTo<Program, $this>
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
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
     * Get the course offerings.
     *
     * @return HasMany<CourseOffering, $this>
     */
    public function courseOfferings(): HasMany
    {
        return $this->hasMany(CourseOffering::class);
    }

    /**
     * Check if the section is full.
     */
    public function isFull(): bool
    {
        return $this->max_students !== null
            && $this->current_count >= $this->max_students;
    }
}
