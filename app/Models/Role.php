<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Role Model
 *
 * Represents a role that can be assigned to users for access control.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property bool $is_system_role
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, User> $users
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Permission> $permissions
 */
final class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_system_role',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_system_role' => 'boolean',
        ];
    }

    /**
     * Get the users that have this role.
     *
     * @return BelongsToMany<User, $this>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Get the permissions assigned to this role.
     *
     * @return BelongsToMany<Permission, $this>
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    /**
     * Assign a permission to this role.
     */
    public function assignPermission(Permission $permission): void
    {
        $this->permissions()->syncWithoutDetaching($permission);
    }

    /**
     * Remove a permission from this role.
     */
    public function removePermission(Permission $permission): void
    {
        $this->permissions()->detach($permission);
    }

    /**
     * Check if this role has a specific permission.
     */
    public function hasPermission(string $slug): bool
    {
        return $this->permissions()->where('slug', $slug)->exists();
    }
}
