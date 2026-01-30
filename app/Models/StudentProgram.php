<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * StudentProgram Model
 *
 * Represents a student's enrollment in a specific program.
 *
 * @property int $id
 * @property int $student_id
 * @property int $program_id
 * @property Carbon $enrollment_date
 * @property string $status
 * @property Carbon|null $graduation_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Student $student
 * @property-read Program $program
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Enrollment> $enrollments
 */
final class StudentProgram extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'program_id',
        'enrollment_date',
        'status',
        'graduation_date',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'enrollment_date' => 'date',
            'graduation_date' => 'date',
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
     * Get the enrollments for this student program.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
