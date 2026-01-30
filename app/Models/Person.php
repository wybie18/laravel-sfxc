<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * Person Model
 *
 * Represents personal information for a user including name, demographics, and profile.
 *
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string|null $middle_name
 * @property string $last_name
 * @property string|null $suffix
 * @property Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $nationality
 * @property string|null $civil_status
 * @property string|null $profile_photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ContactInformation> $contactInformation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Address> $addresses
 */
final class Person extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'people';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'date_of_birth',
        'gender',
        'nationality',
        'civil_status',
        'profile_photo_path',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Get the user that owns this person record.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contact information for this person.
     *
     * @return HasMany<ContactInformation, $this>
     */
    public function contactInformation(): HasMany
    {
        return $this->hasMany(ContactInformation::class);
    }

    /**
     * Get the addresses for this person.
     *
     * @return HasMany<Address, $this>
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the full name of the person.
     */
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->suffix,
        ]);

        return implode(' ', $parts);
    }

    /**
     * Get the formal name (Last, First Middle Suffix).
     */
    public function getFormalNameAttribute(): string
    {
        $name = $this->last_name . ', ' . $this->first_name;

        if ($this->middle_name) {
            $name .= ' ' . $this->middle_name;
        }

        if ($this->suffix) {
            $name .= ' ' . $this->suffix;
        }

        return $name;
    }

    /**
     * Get the primary contact of a specific type.
     */
    public function primaryContact(string $type): ?ContactInformation
    {
        return $this->contactInformation()
            ->where('contact_type', $type)
            ->where('is_primary', true)
            ->first();
    }

    /**
     * Get the primary address.
     */
    public function primaryAddress(): ?Address
    {
        return $this->addresses()
            ->where('is_primary', true)
            ->first();
    }
}
