<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * SystemSetting Model
 *
 * Represents a system configuration setting.
 *
 * @property int $id
 * @property string $setting_key
 * @property string|null $setting_value
 * @property string $value_type
 * @property string|null $description
 * @property string $setting_group
 * @property bool $is_public
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
final class SystemSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'setting_key',
        'setting_value',
        'value_type',
        'description',
        'setting_group',
        'is_public',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = self::where('setting_key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return match ($setting->value_type) {
            'boolean' => filter_var($setting->setting_value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $setting->setting_value,
            'float' => (float) $setting->setting_value,
            'json' => json_decode($setting->setting_value, true),
            default => $setting->setting_value,
        };
    }

    /**
     * Set a setting value.
     */
    public static function setValue(string $key, mixed $value): void
    {
        $stringValue = is_array($value) ? json_encode($value) : (string) $value;

        self::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $stringValue]
        );
    }
}
