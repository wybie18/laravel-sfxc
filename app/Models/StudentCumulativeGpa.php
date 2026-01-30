<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * StudentCumulativeGpa Model
 *
 * Represents a student's cumulative GPA across all semesters.
 *
 * @property int $id
 * @property int $student_id
 * @property float $cumulative_units
 * @property float $cumulative_grade_points
 * @property float $cumulative_gpa
 * @property int $total_semesters
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Student $student
 */
final class StudentCumulativeGpa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'student_cumulative_gpa';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'cumulative_units',
        'cumulative_grade_points',
        'cumulative_gpa',
        'total_semesters',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cumulative_units' => 'decimal:1',
            'cumulative_grade_points' => 'decimal:2',
            'cumulative_gpa' => 'decimal:4',
            'total_semesters' => 'integer',
        ];
    }

    /**
     * Get the student.
     *
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
