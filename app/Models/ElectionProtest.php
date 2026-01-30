<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ElectionProtest Model
 *
 * Represents a protest filed against election results.
 *
 * @property int $id
 * @property int $election_id
 * @property int $filed_by
 * @property string $protest_type
 * @property string $description
 * @property string|null $evidence_path
 * @property string $status
 * @property string|null $resolution
 * @property int|null $resolved_by
 * @property Carbon|null $resolved_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Election $election
 * @property-read Student $filer
 * @property-read Staff|null $resolver
 */
final class ElectionProtest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'election_id',
        'filed_by',
        'protest_type',
        'description',
        'evidence_path',
        'status',
        'resolution',
        'resolved_by',
        'resolved_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'resolved_at' => 'datetime',
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
     * Get the student who filed the protest.
     *
     * @return BelongsTo<Student, $this>
     */
    public function filer(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'filed_by');
    }

    /**
     * Get the staff who resolved the protest.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'resolved_by');
    }
}
