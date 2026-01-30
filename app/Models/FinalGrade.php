<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * FinalGrade Model
 *
 * Represents the final grade for a student's class enrollment.
 *
 * @property int $id
 * @property int $student_class_enrollment_id
 * @property float|null $midterm_grade
 * @property float $final_grade
 * @property string|null $letter_grade
 * @property bool|null $is_passed
 * @property string $remarks
 * @property string $completion_status
 * @property int|null $finalized_by
 * @property Carbon|null $finalized_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentClassEnrollment $studentClassEnrollment
 * @property-read User|null $finalizer
 */
final class FinalGrade extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_class_enrollment_id',
        'midterm_grade',
        'final_grade',
        'letter_grade',
        'is_passed',
        'remarks',
        'completion_status',
        'finalized_by',
        'finalized_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'midterm_grade' => 'decimal:2',
            'final_grade' => 'decimal:2',
            'is_passed' => 'boolean',
            'finalized_at' => 'datetime',
        ];
    }

    /**
     * Get the student class enrollment.
     *
     * @return BelongsTo<StudentClassEnrollment, $this>
     */
    public function studentClassEnrollment(): BelongsTo
    {
        return $this->belongsTo(StudentClassEnrollment::class);
    }

    /**
     * Get the user who finalized this grade.
     *
     * @return BelongsTo<User, $this>
     */
    public function finalizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finalized_by');
    }
}
