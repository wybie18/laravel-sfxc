<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * ClearanceSignatory Model
 *
 * Represents a signatory for a clearance type.
 *
 * @property int $id
 * @property int $clearance_type_id
 * @property string $signatory_type
 * @property int $signatory_id
 * @property int $sequence_order
 * @property bool $is_required
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ClearanceType $clearanceType
 * @property-read Model $signatory
 */
final class ClearanceSignatory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'clearance_type_id',
        'signatory_type',
        'signatory_id',
        'sequence_order',
        'is_required',
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
            'is_required' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the clearance type.
     *
     * @return BelongsTo<ClearanceType, $this>
     */
    public function clearanceType(): BelongsTo
    {
        return $this->belongsTo(ClearanceType::class);
    }

    /**
     * Get the signatory (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function signatory(): MorphTo
    {
        return $this->morphTo();
    }
}
