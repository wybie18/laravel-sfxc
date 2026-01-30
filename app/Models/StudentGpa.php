<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * StudentGpa Model
 *
 * Represents a student's GPA for a specific enrollment/semester.
 *
 * @property int $id
 * @property int $enrollment_id
 * @property float $total_units
 * @property float $total_grade_points
 * @property float $gpa
 * @property int $subjects_taken
 * @property int $subjects_passed
 * @property int $subjects_failed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Enrollment $enrollment
 */
final class StudentGpa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'student_gpa';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'enrollment_id',
        'total_units',
        'total_grade_points',
        'gpa',
        'subjects_taken',
        'subjects_passed',
        'subjects_failed',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_units' => 'decimal:1',
            'total_grade_points' => 'decimal:2',
            'gpa' => 'decimal:4',
            'subjects_taken' => 'integer',
            'subjects_passed' => 'integer',
            'subjects_failed' => 'integer',
        ];
    }

    /**
     * Get the enrollment.
     *
     * @return BelongsTo<Enrollment, $this>
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }
}
