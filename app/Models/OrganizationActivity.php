<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * OrganizationActivity Model
 *
 * Represents an activity organized by a student organization.
 *
 * @property int $id
 * @property int $organization_id
 * @property string $activity_name
 * @property string|null $description
 * @property Carbon $activity_date
 * @property string|null $venue
 * @property string $status
 * @property int|null $approved_by
 * @property Carbon|null $approved_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read StudentOrganization $organization
 * @property-read Staff|null $approver
 */
final class OrganizationActivity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'organization_activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'organization_id',
        'activity_name',
        'description',
        'activity_date',
        'venue',
        'status',
        'approved_by',
        'approved_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'datetime',
            'approved_at' => 'datetime',
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
     * Get the approver.
     *
     * @return BelongsTo<Staff, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'approved_by');
    }
}
