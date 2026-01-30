<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * SubjectPrerequisite Model
 *
 * Represents a prerequisite relationship between subjects.
 *
 * @property int $id
 * @property int $subject_id
 * @property int $prerequisite_subject_id
 * @property string $prerequisite_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Subject $subject
 * @property-read Subject $prerequisiteSubject
 */
final class SubjectPrerequisite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'subject_id',
        'prerequisite_subject_id',
        'prerequisite_type',
    ];

    /**
     * Get the subject that requires this prerequisite.
     *
     * @return BelongsTo<Subject, $this>
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the prerequisite subject.
     *
     * @return BelongsTo<Subject, $this>
     */
    public function prerequisiteSubject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'prerequisite_subject_id');
    }
}
