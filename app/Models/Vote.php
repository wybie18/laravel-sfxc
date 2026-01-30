<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Vote Model
 *
 * Represents a vote cast in an election.
 *
 * @property int $id
 * @property int $election_id
 * @property int $election_position_id
 * @property int $candidate_id
 * @property string $vote_hash
 * @property Carbon $voted_at
 *
 * @property-read Election $election
 * @property-read ElectionPosition $electionPosition
 * @property-read Candidate $candidate
 */
final class Vote extends Model
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
        'election_id',
        'election_position_id',
        'candidate_id',
        'vote_hash',
        'voted_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'voted_at' => 'datetime',
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
     * Get the candidate.
     *
     * @return BelongsTo<Candidate, $this>
     */
    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }
}
