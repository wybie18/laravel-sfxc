<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ElectionPosition Model
 *
 * Represents a position available in an election.
 *
 * @property int $id
 * @property int $election_id
 * @property int $position_id
 * @property int $slots_available
 * @property int $max_votes_per_voter
 * @property int $sequence_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Election $election
 * @property-read OfficerPosition $position
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Candidate> $candidates
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ElectionResult> $results
 */
final class ElectionPosition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'election_id',
        'position_id',
        'slots_available',
        'max_votes_per_voter',
        'sequence_order',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'slots_available' => 'integer',
            'max_votes_per_voter' => 'integer',
            'sequence_order' => 'integer',
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
     * Get the position.
     *
     * @return BelongsTo<OfficerPosition, $this>
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(OfficerPosition::class, 'position_id');
    }

    /**
     * Get the candidates.
     *
     * @return HasMany<Candidate, $this>
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get the results.
     *
     * @return HasMany<ElectionResult, $this>
     */
    public function results(): HasMany
    {
        return $this->hasMany(ElectionResult::class);
    }
}
