<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Grade Model
 *
 * Represents a grade for a specific grading component.
 *
 * @property int $id
 * @property int $student_class_enrollment_id
 * @property int $class_grading_structure_id
 * @property float $score
 * @property float $max_score
 * @property float $percentage
 * @property string|null $remarks
 * @property int $recorded_by
 * @property Carbon $recorded_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentClassEnrollment $studentClassEnrollment
 * @property-read ClassGradingStructure $classGradingStructure
 * @property-read User $recorder
 */
final class Grade extends Model
{
    use HasFactory;

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
        'student_class_enrollment_id',
        'class_grading_structure_id',
        'score',
        'max_score',
        'remarks',
        'recorded_by',
        'recorded_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'max_score' => 'decimal:2',
            'percentage' => 'decimal:2',
            'recorded_at' => 'datetime',
            'updated_at' => 'datetime',
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
     * Get the class grading structure.
     *
     * @return BelongsTo<ClassGradingStructure, $this>
     */
    public function classGradingStructure(): BelongsTo
    {
        return $this->belongsTo(ClassGradingStructure::class);
    }

    /**
     * Get the user who recorded this grade.
     *
     * @return BelongsTo<User, $this>
     */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
