<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Candidate Model
 *
 * Represents a candidate in an election.
 *
 * @property int $id
 * @property int $election_id
 * @property int $election_position_id
 * @property int $student_id
 * @property string|null $platform
 * @property string|null $photo_path
 * @property string $status
 * @property int|null $reviewed_by
 * @property Carbon|null $reviewed_at
 * @property string|null $disqualification_reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Election $election
 * @property-read ElectionPosition $electionPosition
 * @property-read Student $student
 * @property-read Staff|null $reviewer
 */
final class Candidate extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'election_id',
        'election_position_id',
        'student_id',
        'platform',
        'photo_path',
        'status',
        'reviewed_by',
        'reviewed_at',
        'disqualification_reason',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Get the election.
     *
     * @return BelongsTo<Election, $this>
     */
    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    /**
     * Get the election position.
     *
     * @return BelongsTo<ElectionPosition, $this>
     */
    public function electionPosition(): BelongsTo
    {
        return $this->belongsTo(ElectionPosition::class);
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
     * Get the reviewer.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'reviewed_by');
    }

    /**
     * Get the endorsements received.
     *
     * @return HasMany<CandidateEndorsement, $this>
     */
    public function endorsements(): HasMany
    {
        return $this->hasMany(CandidateEndorsement::class);
    }

    /**
     * Get the votes received.
     *
     * @return HasMany<Vote, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Check if the candidate is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
