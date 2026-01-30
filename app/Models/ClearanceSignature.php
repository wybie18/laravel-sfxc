<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ClearanceSignature Model
 *
 * Represents a signature on a clearance request.
 *
 * @property int $id
 * @property int $clearance_request_id
 * @property int $clearance_signatory_id
 * @property string $signature_status
 * @property int|null $signed_by
 * @property Carbon|null $signed_at
 * @property string|null $remarks
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read ClearanceRequest $clearanceRequest
 * @property-read ClearanceSignatory $clearanceSignatory
 * @property-read User|null $signer
 */
final class ClearanceSignature extends Model
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
        'signature_status',
        'signed_by',
        'signed_at',
        'remarks',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'signed_at' => 'datetime',
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
     * Get the user who signed.
     *
     * @return BelongsTo<User, $this>
     */
    public function signer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}
