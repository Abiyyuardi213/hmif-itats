<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OrganizationSetting extends Model
{
    public const CACHE_KEY = 'hmif_organization_settings';

    protected $fillable = ['key', 'value'];

    public static function allCached(): array
    {
        return Cache::remember(self::CACHE_KEY, 3600, function () {
            return static::query()->pluck('value', 'key')->all();
        });
    }

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $all = self::allCached();

        return $all[$key] ?? $default;
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Cache::forget(self::CACHE_KEY);
    }
}
