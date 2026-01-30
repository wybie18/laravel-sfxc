<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Address Model
 *
 * Represents a physical address for a person.
 *
 * @property int $id
 * @property int $person_id
 * @property string $address_type
 * @property string|null $street_address
 * @property string|null $barangay
 * @property string|null $city
 * @property string|null $province
 * @property string|null $region
 * @property string|null $postal_code
 * @property string $country
 * @property bool $is_primary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Person $person
 */
final class Address extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'person_id',
        'address_type',
        'street_address',
        'barangay',
        'city',
        'province',
        'region',
        'postal_code',
        'country',
        'is_primary',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_primary' => 'boolean',
        ];
    }

    /**
     * Get the person that owns this address.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->street_address,
            $this->barangay,
            $this->city,
            $this->province,
            $this->region,
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }
}
