<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ClearanceRequest Model
 *
 * Represents a student's clearance request.
 *
 * @property int $id
 * @property int $student_id
 * @property int $clearance_type_id
 * @property int $semester_id
 * @property string $request_status
 * @property Carbon $requested_at
 * @property Carbon|null $completed_at
 * @property string|null $purpose
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Student $student
 * @property-read ClearanceType $clearanceType
 * @property-read Semester $semester
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClearanceSignature> $signatures
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClearanceDeficiency> $deficiencies
 */
final class ClearanceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'clearance_type_id',
        'semester_id',
        'request_status',
        'requested_at',
        'completed_at',
        'purpose',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'requested_at' => 'datetime',
            'completed_at' => 'datetime',
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
     * Get the clearance type.
     *
     * @return BelongsTo<ClearanceType, $this>
     */
    public function clearanceType(): BelongsTo
    {
        return $this->belongsTo(ClearanceType::class);
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
     * Get the signatures.
     *
     * @return HasMany<ClearanceSignature, $this>
     */
    public function signatures(): HasMany
    {
        return $this->hasMany(ClearanceSignature::class);
    }

    /**
     * Get the deficiencies.
     *
     * @return HasMany<ClearanceDeficiency, $this>
     */
    public function deficiencies(): HasMany
    {
        return $this->hasMany(ClearanceDeficiency::class);
    }

    /**
     * Check if the clearance is completed.
     */
    public function isCompleted(): bool
    {
        return $this->request_status === 'completed';
    }
}
