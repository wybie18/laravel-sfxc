<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ClearanceDeficiency Model
 *
 * Represents a deficiency that prevents clearance approval.
 *
 * @property int $id
 * @property int $clearance_request_id
 * @property int $clearance_signatory_id
 * @property string $deficiency_description
 * @property string $deficiency_status
 * @property int|null $resolved_by
 * @property Carbon|null $resolved_at
 * @property string|null $resolution_notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ClearanceRequest $clearanceRequest
 * @property-read ClearanceSignatory $clearanceSignatory
 * @property-read User|null $resolver
 */
final class ClearanceDeficiency extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'clearance_request_id',
        'clearance_signatory_id',
        'deficiency_description',
        'deficiency_status',
        'resolved_by',
        'resolved_at',
        'resolution_notes',
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
     * Get the clearance request.
     *
     * @return BelongsTo<ClearanceRequest, $this>
     */
    public function clearanceRequest(): BelongsTo
    {
        return $this->belongsTo(ClearanceRequest::class);
    }

    /**
     * Get the clearance signatory.
     *
     * @return BelongsTo<ClearanceSignatory, $this>
     */
    public function clearanceSignatory(): BelongsTo
    {
        return $this->belongsTo(ClearanceSignatory::class);
    }

    /**
     * Get the user who resolved this deficiency.
     *
     * @return BelongsTo<User, $this>
     */
    public function resolver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    /**
     * Check if the deficiency is resolved.
     */
    public function isResolved(): bool
    {
        return $this->deficiency_status === 'resolved';
    }
}
