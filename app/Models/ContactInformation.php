<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * ContactInformation Model
 *
 * Represents contact information (phone, email, etc.) for a person.
 *
 * @property int $id
 * @property int $person_id
 * @property string $contact_type
 * @property string $contact_value
 * @property bool $is_primary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Person $person
 */
final class ContactInformation extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'contact_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'person_id',
        'contact_type',
        'contact_value',
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
     * Get the person that owns this contact information.
     *
     * @return BelongsTo<Person, $this>
     */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
