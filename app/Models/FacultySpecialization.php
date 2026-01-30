<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * FacultySpecialization Model
 *
 * Represents a faculty member's specialization.
 *
 * @property int $id
 * @property int $faculty_id
 * @property int $specialization_id
 * @property string $proficiency_level
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Faculty $faculty
 * @property-read Specialization $specialization
 */
final class FacultySpecialization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'faculty_id',
        'specialization_id',
        'proficiency_level',
    ];

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
     * Get the specialization.
     *
     * @return BelongsTo<Specialization, $this>
     */
    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }
}
