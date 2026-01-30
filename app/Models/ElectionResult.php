<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ElectionResult Model
 *
 * Represents the results of an election.
 *
 * @property int $id
 * @property int $election_id
 * @property int $election_position_id
 * @property int $candidate_id
 * @property int $vote_count
 * @property int|null $rank
 * @property bool $is_winner
 * @property Carbon $certified_at
 * @property int $certified_by
 *
 * @property-read Election $election
 * @property-read ElectionPosition $electionPosition
 * @property-read Candidate $candidate
 * @property-read Staff $certifier
 */
final class ElectionResult extends Model
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
        'vote_count',
        'rank',
        'is_winner',
        'certified_at',
        'certified_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vote_count' => 'integer',
            'rank' => 'integer',
            'is_winner' => 'boolean',
            'certified_at' => 'datetime',
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

    /**
     * Get the certifier.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function certifier(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'certified_by');
    }
}
