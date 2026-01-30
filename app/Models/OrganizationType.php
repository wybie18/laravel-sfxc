<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * OrganizationType Model
 *
 * Represents a type of student organization.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $requires_approval
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, StudentOrganization> $organizations
 */
final class OrganizationType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'requires_approval',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'requires_approval' => 'boolean',
        ];
    }

    /**
     * Get the student organizations of this type.
     *
     * @return HasMany<StudentOrganization, $this>
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(StudentOrganization::class);
    }
}
