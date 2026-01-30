<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Office Model
 *
 * Represents an administrative or support office within the institution.
 *
 * @property int $id
 * @property string $office_code
 * @property string $office_name
 * @property string $office_type
 * @property int|null $parent_office_id
 * @property string|null $description
 * @property string|null $building_location
 * @property string|null $room_number
 * @property string|null $contact_email
 * @property string|null $contact_phone
 * @property int|null $office_head_staff_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Office|null $parentOffice
 * @property-read Staff|null $officeHead
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Office> $childOffices
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Staff> $staff
 */
final class Office extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'office_code',
        'office_name',
        'office_type',
        'parent_office_id',
        'description',
        'building_location',
        'room_number',
        'contact_email',
        'contact_phone',
        'office_head_staff_id',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the parent office.
     *
     * @return BelongsTo<Office, $this>
     */
    public function parentOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'parent_office_id');
    }

    /**
     * Get the office head.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function officeHead(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'office_head_staff_id');
    }

    /**
     * Get the child offices.
     *
     * @return HasMany<Office, $this>
     */
    public function childOffices(): HasMany
    {
        return $this->hasMany(Office::class, 'parent_office_id');
    }

    /**
     * Get the staff members in this office.
     *
     * @return HasMany<Staff, $this>
     */
    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class);
    }

    /**
     * Get the office head history.
     *
     * @return HasMany<OfficeHead, $this>
     */
    public function headHistory(): HasMany
    {
        return $this->hasMany(OfficeHead::class);
    }

    /**
     * Get the responsibilities of this office.
     *
     * @return HasMany<OfficeResponsibility, $this>
     */
    public function responsibilities(): HasMany
    {
        return $this->hasMany(OfficeResponsibility::class);
    }

    /**
     * Get the services provided by this office.
     *
     * @return HasMany<OfficeService, $this>
     */
    public function services(): HasMany
    {
        return $this->hasMany(OfficeService::class);
    }
}
