<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * NotificationTemplate Model
 *
 * Represents a notification template.
 *
 * @property int $id
 * @property string $template_code
 * @property string $template_name
 * @property string $channel
 * @property string $subject_template
 * @property string $body_template
 * @property array|null $variables
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class NotificationTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'template_code',
        'template_name',
        'channel',
        'subject_template',
        'body_template',
        'variables',
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
            'variables' => 'json',
            'is_active' => 'boolean',
        ];
    }
}
