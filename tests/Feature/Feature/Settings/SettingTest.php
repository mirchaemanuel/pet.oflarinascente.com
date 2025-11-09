<?php

declare(strict_types=1);

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

test('can create a setting', function (): void {
    // Arrange & Act
    $setting = Setting::create([
        'key' => 'test_setting',
        'value' => 'test value',
        'group' => 'general',
        'type' => 'text',
        'description' => 'Test setting',
    ]);

    // Assert
    expect($setting->key)->toBe('test_setting')
        ->and($setting->value)->toBe('test value')
        ->and($setting->group)->toBe('general')
        ->and($setting->type)->toBe('text');

    $this->assertDatabaseHas('settings', [
        'key' => 'test_setting',
        'value' => 'test value',
    ]);
});

test('can get setting value by key', function (): void {
    // Arrange
    Setting::create([
        'key' => 'site_name',
        'value' => 'Pet Memorial',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Act
    $value = Setting::get('site_name');

    // Assert
    expect($value)->toBe('Pet Memorial');
});

test('returns default value when setting does not exist', function (): void {
    // Act
    $value = Setting::get('nonexistent_key', 'default value');

    // Assert
    expect($value)->toBe('default value');
});

test('can set setting value', function (): void {
    // Act
    Setting::set('new_setting', 'new value');

    // Assert
    $this->assertDatabaseHas('settings', [
        'key' => 'new_setting',
        'value' => 'new value',
    ]);
});

test('setting value is cached', function (): void {
    // Arrange
    Setting::create([
        'key' => 'cached_setting',
        'value' => 'cached value',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Act - First call should cache the value
    $firstValue = Setting::get('cached_setting');

    // Assert - Check if value is in cache
    expect(Cache::has('setting.cached_setting'))->toBeTrue()
        ->and($firstValue)->toBe('cached value');
});

test('cache is cleared when setting is updated', function (): void {
    // Arrange
    $setting = Setting::create([
        'key' => 'updatable_setting',
        'value' => 'original value',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Cache the value
    Setting::get('updatable_setting');
    expect(Cache::has('setting.updatable_setting'))->toBeTrue();

    // Act - Update the setting
    $setting->update(['value' => 'updated value']);

    // Assert - Cache should be cleared
    expect(Cache::has('setting.updatable_setting'))->toBeFalse();

    // Verify the new value can be retrieved
    $newValue = Setting::get('updatable_setting');
    expect($newValue)->toBe('updated value');
});

test('cache is cleared when setting is deleted', function (): void {
    // Arrange
    $setting = Setting::create([
        'key' => 'deletable_setting',
        'value' => 'value to delete',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Cache the value
    Setting::get('deletable_setting');
    expect(Cache::has('setting.deletable_setting'))->toBeTrue();

    // Act - Delete the setting
    $setting->delete();

    // Assert - Cache should be cleared
    expect(Cache::has('setting.deletable_setting'))->toBeFalse();
});

test('can get all settings grouped', function (): void {
    // Arrange
    Setting::create([
        'key' => 'general_setting_1',
        'value' => 'value 1',
        'group' => 'general',
        'type' => 'text',
    ]);

    Setting::create([
        'key' => 'general_setting_2',
        'value' => 'value 2',
        'group' => 'general',
        'type' => 'text',
    ]);

    Setting::create([
        'key' => 'contact_setting_1',
        'value' => 'contact value',
        'group' => 'contact',
        'type' => 'email',
    ]);

    // Act
    $grouped = Setting::getAllGrouped();

    // Assert
    expect($grouped)->toBeArray()
        ->and($grouped)->toHaveKeys(['general', 'contact'])
        ->and($grouped['general'])->toHaveKey('general_setting_1')
        ->and($grouped['general'])->toHaveKey('general_setting_2')
        ->and($grouped['contact'])->toHaveKey('contact_setting_1');
});

test('setting helper function works', function (): void {
    // Arrange
    Setting::create([
        'key' => 'helper_test',
        'value' => 'helper value',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Act
    $value = setting('helper_test');

    // Assert
    expect($value)->toBe('helper value');
});

test('setting helper function returns default', function (): void {
    // Act
    $value = setting('nonexistent', 'default');

    // Assert
    expect($value)->toBe('default');
});

test('settings helper function returns all settings', function (): void {
    // Arrange
    Setting::create([
        'key' => 'setting_1',
        'value' => 'value 1',
        'group' => 'general',
        'type' => 'text',
    ]);

    Setting::create([
        'key' => 'setting_2',
        'value' => 'value 2',
        'group' => 'contact',
        'type' => 'text',
    ]);

    // Act
    $all = settings();

    // Assert
    expect($all)->toBeArray()
        ->and($all)->toHaveKey('setting_1')
        ->and($all)->toHaveKey('setting_2');
});

test('settings helper function returns settings by group', function (): void {
    // Arrange
    Setting::create([
        'key' => 'general_setting',
        'value' => 'general value',
        'group' => 'general',
        'type' => 'text',
    ]);

    Setting::create([
        'key' => 'contact_setting',
        'value' => 'contact value',
        'group' => 'contact',
        'type' => 'text',
    ]);

    // Act
    $generalSettings = settings('general');

    // Assert
    expect($generalSettings)->toBeArray()
        ->and($generalSettings)->toHaveKey('general_setting')
        ->and($generalSettings)->not->toHaveKey('contact_setting');
});

test('unique key constraint is enforced', function (): void {
    // Arrange
    Setting::create([
        'key' => 'unique_key',
        'value' => 'value 1',
        'group' => 'general',
        'type' => 'text',
    ]);

    // Act & Assert - Expect exception when creating duplicate key
    expect(fn () => Setting::create([
        'key' => 'unique_key',
        'value' => 'value 2',
        'group' => 'general',
        'type' => 'text',
    ]))->toThrow(Exception::class);
});
