<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * FileUpload Model
 *
 * Represents an uploaded file.
 *
 * @property int $id
 * @property string $file_name
 * @property string $original_name
 * @property string $file_path
 * @property string $file_type
 * @property string $mime_type
 * @property int $file_size
 * @property string|null $uploadable_type
 * @property int|null $uploadable_id
 * @property int $uploaded_by
 * @property Carbon $uploaded_at
 *
 * @property-read User $uploader
 * @property-read Model|null $uploadable
 */
final class FileUpload extends Model
{
    use HasFactory;

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
        'file_name',
        'original_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'uploadable_type',
        'uploadable_id',
        'uploaded_by',
        'uploaded_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'file_size' => 'integer',
            'uploaded_at' => 'datetime',
        ];
    }

    /**
     * Get the uploader.
     *
     * @return BelongsTo<User, $this>
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the uploadable model (polymorphic).
     *
     * @return MorphTo<Model, $this>
     */
    public function uploadable(): MorphTo
    {
        return $this->morphTo();
    }
}
