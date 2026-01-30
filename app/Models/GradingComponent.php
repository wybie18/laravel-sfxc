<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * GradingComponent Model
 *
 * Represents a grading component type (quiz, exam, project, etc.).
 *
 * @property int $id
 * @property string $component_name
 * @property string|null $description
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, ClassGradingStructure> $classGradingStructures
 */
final class GradingComponent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'component_name',
        'description',
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
     * Get the class grading structures using this component.
     *
     * @return HasMany<ClassGradingStructure, $this>
     */
    public function classGradingStructures(): HasMany
    {
        return $this->hasMany(ClassGradingStructure::class);
    }
}
