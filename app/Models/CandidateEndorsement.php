<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * CandidateEndorsement Model
 *
 * Represents an endorsement for a candidate.
 *
 * @property int $id
 * @property int $candidate_id
 * @property int $endorsed_by
 * @property string|null $endorsement_message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Candidate $candidate
 * @property-read StudentOfficer $endorser
 */
final class CandidateEndorsement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'candidate_id',
        'endorsed_by',
        'endorsement_message',
    ];

    /**
     * Get the candidate.
     *
     * @return BelongsTo<Candidate, $this>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    /**
     * Get the endorser.
     *
     * @return BelongsTo<StudentOfficer, $this>
     */
    public function endorser(): BelongsTo
    {
        return $this->belongsTo(StudentOfficer::class, 'endorsed_by');
    }
}
