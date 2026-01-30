<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * ClearanceType Model
 *
 * Represents a type of clearance requirement.
 *
 * @property int $id
 * @property string $type_code
 * @property string $type_name
 * @property string|null $description
 * @property int $sequence_order
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClearanceSignatory> $signatories
 */
final class ClearanceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type_code',
        'type_name',
        'description',
        'sequence_order',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sequence_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the signatories for this clearance type.
     *
     * @return HasMany<ClearanceSignatory, $this>
     */
    public function signatories(): HasMany
    {
        return $this->hasMany(ClearanceSignatory::class);
    }
}
