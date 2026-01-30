<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * DocumentNumber Model
 *
 * Represents a document number sequence for official documents.
 *
 * @property int $id
 * @property string $document_type
 * @property int $academic_year_id
 * @property string $prefix
 * @property int $last_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read AcademicYear $academicYear
 */
final class DocumentNumber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'document_type',
        'academic_year_id',
        'prefix',
        'last_number',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'last_number' => 'integer',
        ];
    }

    /**
     * Get the academic year.
     *
     * @return BelongsTo<AcademicYear, $this>
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the next document number.
     */
    public function getNextNumber(): string
    {
        $this->increment('last_number');

        return $this->prefix.str_pad((string) $this->last_number, 6, '0', STR_PAD_LEFT);
    }
}
