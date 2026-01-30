<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Election Model
 *
 * Represents an election.
 *
 * @property int $id
 * @property string $election_name
 * @property int $academic_year_id
 * @property int $semester_id
 * @property int|null $organization_id
 * @property string|null $election_scope_type
 * @property int|null $election_scope_id
 * @property Carbon $nomination_start
 * @property Carbon $nomination_end
 * @property Carbon $campaign_start
 * @property Carbon $campaign_end
 * @property Carbon $voting_start
 * @property Carbon $voting_end
 * @property string $status
 * @property int|null $comelec_chair_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read AcademicYear $academicYear
 * @property-read Semester $semester
 * @property-read StudentOrganization|null $organization
 * @property-read Model|null $electionScope
 * @property-read Staff|null $comelecChair
 */
final class Election extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'election_name',
        'academic_year_id',
        'semester_id',
        'organization_id',
        'election_scope_type',
        'election_scope_id',
        'nomination_start',
        'nomination_end',
        'campaign_start',
        'campaign_end',
        'voting_start',
        'voting_end',
        'status',
        'comelec_chair_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nomination_start' => 'datetime',
            'nomination_end' => 'datetime',
            'campaign_start' => 'datetime',
            'campaign_end' => 'datetime',
            'voting_start' => 'datetime',
            'voting_end' => 'datetime',
        ];
    }

    /**
     * Get the academic year.
     *
     * @return BelongsTo<AcademicYear, $this>
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
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
     * Get the organization.
     *
     * @return BelongsTo<StudentOrganization, $this>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(StudentOrganization::class, 'organization_id');
    }

    /**
     * Get the election scope (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function electionScope(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the COMELEC chair.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function comelecChair(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'comelec_chair_id');
    }

    /**
     * Get the positions.
     *
     * @return HasMany<ElectionPosition, $this>
     */
    public function positions(): HasMany
    {
        return $this->hasMany(ElectionPosition::class);
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
     * Get the eligible voters.
     *
     * @return HasMany<EligibleVoter, $this>
     */
    public function eligibleVoters(): HasMany
    {
        return $this->hasMany(EligibleVoter::class);
    }

    /**
     * Get the votes.
     *
     * @return HasMany<Vote, $this>
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
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

    /**
     * Get the protests.
     *
     * @return HasMany<ElectionProtest, $this>
     */
    public function protests(): HasMany
    {
        return $this->hasMany(ElectionProtest::class);
    }

    /**
     * Check if voting is currently open.
     */
    public function isVotingOpen(): bool
    {
        $now = now();

        return $this->status === 'active'
            && $now->between($this->voting_start, $this->voting_end);
    }
}
