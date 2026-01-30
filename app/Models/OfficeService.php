<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * OfficeService Model
 *
 * Represents a service provided by an office.
 *
 * @property int $id
 * @property int $office_id
 * @property string $name
 * @property string|null $description
 * @property string|null $requirements
 * @property int|null $processing_days
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Office $office
 */
final class OfficeService extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'office_id',
        'name',
        'description',
        'requirements',
        'processing_days',
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
            'processing_days' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the office.
     *
     * @return BelongsTo<Office, $this>
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class);
    }
}
