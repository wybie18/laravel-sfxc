<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * EligibleVoter Model
 *
 * Represents a student eligible to vote in an election.
 *
 * @property int $id
 * @property int $election_id
 * @property int $student_id
 * @property bool $has_voted
 * @property Carbon|null $voted_at
 *
 * @property-read Election $election
 * @property-read Student $student
 */
final class EligibleVoter extends Model
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
        'student_id',
        'has_voted',
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
            'has_voted' => 'boolean',
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
     * Get the student.
     *
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Mark as voted.
     */
    public function markAsVoted(): void
    {
        $this->update([
            'has_voted' => true,
            'voted_at' => now(),
        ]);
    }
}
