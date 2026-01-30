<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * GradeHistory Model
 *
 * Represents historical changes to a grade.
 *
 * @property int $id
 * @property int $grade_id
 * @property float $old_score
 * @property float $new_score
 * @property string|null $change_reason
 * @property int $changed_by
 * @property Carbon $changed_at
 *
 * @property-read Grade $grade
 * @property-read User $changer
 */
final class GradeHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'grade_history';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'grade_id',
        'old_score',
        'new_score',
        'change_reason',
        'changed_by',
        'changed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'old_score' => 'decimal:2',
            'new_score' => 'decimal:2',
            'changed_at' => 'datetime',
        ];
    }

    /**
     * Get the grade.
     *
     * @return BelongsTo<Grade, $this>
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Get the user who changed the grade.
     *
     * @return BelongsTo<User, $this>
     */
    public function changer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
