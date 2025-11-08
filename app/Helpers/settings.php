<?php

declare(strict_types=1);

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param  string  $key  The setting key
     * @param  mixed  $default  Default value if setting not found
     */
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

if (! function_exists('settings')) {
    /**
     * Get all settings or settings for a specific group.
     *
     * @param  string|null  $group  Optional group to filter by
     * @return array<string, mixed>
     */
    function settings(?string $group = null): array
    {
        $allSettings = Setting::getAllGrouped();

        if ($group !== null) {
            return $allSettings[$group] ?? [];
        }

        // Merge all groups into a single array
        $result = [];
        foreach ($allSettings as $groupSettings) {
            $result = array_merge($result, $groupSettings);
        }

        return $result;
    }
}
