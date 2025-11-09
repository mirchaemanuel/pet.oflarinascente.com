<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\LogsActivityAllDirty;
use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @method static SettingFactory factory($count = null, $state = [])
 */
class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    use LogsActivityAllDirty;

    /**
     * Get a setting value by key, with optional default
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever(
            "setting.{$key}",
            fn () => self::where('key', $key)->value('value') ?? $default
        );
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting.{$key}");
    }

    /**
     * Get all settings grouped by group
     *
     * @return array<string, array<string, mixed>>
     */
    public static function getAllGrouped(): array
    {
        return self::all()
            ->groupBy('group')
            ->map(fn ($settings) => $settings->pluck('value', 'key')->toArray())
            ->toArray();
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        self::all()->each(fn ($setting) => Cache::forget("setting.{$setting->key}"));
    }

    protected static function booted(): void
    {
        // Clear cache when a setting is updated or deleted
        static::saved(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
        static::deleted(fn (Setting $setting) => Cache::forget("setting.{$setting->key}"));
    }

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
        ];
    }
}
