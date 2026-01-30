<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * EnrollmentRequirement Model
 *
 * Represents a requirement for enrollment.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $requirement_type
 * @property bool $is_mandatory
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentEnrollmentRequirement> $studentRequirements
 */
final class EnrollmentRequirement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'requirement_type',
        'is_mandatory',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_mandatory' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the student requirements.
     *
     * @return HasMany<StudentEnrollmentRequirement, $this>
     */
    public function studentRequirements(): HasMany
    {
        return $this->hasMany(StudentEnrollmentRequirement::class, 'requirement_id');
    }
}
