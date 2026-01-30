<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * OfficerPosition Model
 *
 * Represents an officer position in an organization.
 *
 * @property int $id
 * @property int|null $organization_id
 * @property string $position_name
 * @property int $hierarchy_level
 * @property string|null $responsibilities
 * @property int $max_holders
 * @property bool $is_executive
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentOrganization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ElectionPosition> $electionPositions
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentOfficer> $officers
 */
final class OfficerPosition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'position_name',
        'hierarchy_level',
        'responsibilities',
        'max_holders',
        'is_executive',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hierarchy_level' => 'integer',
            'max_holders' => 'integer',
            'is_executive' => 'boolean',
        ];
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
     * Get the election positions.
     *
     * @return HasMany<ElectionPosition, $this>
     */
    public function electionPositions(): HasMany
    {
        return $this->hasMany(ElectionPosition::class, 'position_id');
    }

    /**
     * Get the officers holding this position.
     *
     * @return HasMany<StudentOfficer, $this>
     */
    public function officers(): HasMany
    {
        return $this->hasMany(StudentOfficer::class, 'position_id');
    }
}
