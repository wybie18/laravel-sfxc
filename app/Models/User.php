<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * User Model
 *
 * Represents a system user with authentication capabilities.
 *
 * @property int $id
 * @property int $rfid_uid
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property Carbon|null $last_login_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property-read Person|null $person
 * @property-read Student|null $student
 * @property-read Faculty|null $faculty
 * @property-read Staff|null $staff
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Role> $roles
 * @property-read \Illuminate\Database\Eloquent\Collection<int, LoginHistory> $loginHistory
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ActivityLog> $activityLogs
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Notification> $notifications
 */
final class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'rfid_uid',
        'email',
        'password',
        'is_active',
        'last_login_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'rfid_uid' => 'integer',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the person profile associated with the user.
     *
     * @return HasOne<Person, $this>
     */
    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    /**
     * Get the student record associated with the user.
     *
     * @return HasOne<Student, $this>
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the faculty record associated with the user.
     *
     * @return HasOne<Faculty, $this>
     */
    public function faculty(): HasOne
    {
        return $this->hasOne(Faculty::class);
    }

    /**
     * Get the staff record associated with the user.
     *
     * @return HasOne<Staff, $this>
     */
    public function staff(): HasOne
    {
        return $this->hasOne(Staff::class);
    }

    /**
     * Get the roles assigned to the user.
     *
     * @return BelongsToMany<Role, $this>
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Get the login history records for the user.
     *
     * @return HasMany<LoginHistory, $this>
     */
    public function loginHistory(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
    }

    /**
     * Get the activity logs for the user.
     *
     * @return HasMany<ActivityLog, $this>
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param array<string> $slugs
     */
    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles()->whereIn('slug', $slugs)->exists();
    }

    /**
     * Check if the user has a specific permission through their roles.
     */
    public function hasPermission(string $slug): bool
    {
        return $this->roles()
            ->whereHas('permissions', fn ($query) => $query->where('slug', $slug))
            ->exists();
    }
}
