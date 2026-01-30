<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * FacultyPosition Model
 *
 * Represents a faculty position type.
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $rank
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Faculty> $faculty
 */
final class FacultyPosition extends Model
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
        'rank',
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
            'rank' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the faculty members with this position.
     *
     * @return HasMany<Faculty, $this>
     */
    public function faculty(): HasMany
    {
        return $this->hasMany(Faculty::class, 'position_id');
    }
}
