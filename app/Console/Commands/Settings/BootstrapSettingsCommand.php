<?php

declare(strict_types=1);

namespace App\Console\Commands\Settings;

use App\Models\Setting;
use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class BootstrapSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'settings:bootstrap
                            {--file=config/settings.yaml : Path to the YAML settings file}
                            {--force : Force update existing settings}
                            {--clear-cache : Clear settings cache after bootstrap}';

    /**
     * The console command description.
     */
    protected $description = 'Bootstrap application settings from a YAML configuration file';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->newLine();
        $this->info('========================================');
        $this->info('  Bootstrap Application Settings');
        $this->info('========================================');
        $this->newLine();

        $filePath = base_path($this->option('file'));

        // Check if file exists
        if (! file_exists($filePath)) {
            $this->error("Settings file not found: {$filePath}");
            $this->newLine();
            $this->line('Please create the settings file or specify a different path using --file option.');
            $this->newLine();

            return self::FAILURE;
        }

        $this->info("Loading settings from: {$filePath}");

        try {
            // Parse YAML file
            $settings = Yaml::parseFile($filePath);

            if (empty($settings) || ! is_array($settings)) {
                $this->error('Invalid settings file format. Expected an array of settings.');

                return self::FAILURE;
            }

            $this->info('Found '.count($settings).' settings to process.');
            $this->newLine();

            $force = $this->option('force');
            $created = 0;
            $updated = 0;
            $skipped = 0;

            // Progress bar
            $bar = $this->output->createProgressBar(count($settings));
            $bar->start();

            foreach ($settings as $settingData) {
                // Validate required fields
                if (! isset($settingData['key'])) {
                    $skipped++;
                    $bar->advance();

                    continue;
                }

                $key = $settingData['key'];
                $existingSetting = Setting::where('key', $key)->first();

                if ($existingSetting && ! $force) {
                    $skipped++;
                    $bar->advance();

                    continue;
                }

                if ($existingSetting) {
                    $existingSetting->update($settingData);
                    $updated++;
                } else {
                    Setting::create($settingData);
                    $created++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);

            // Clear cache if requested
            if ($this->option('clear-cache')) {
                Setting::clearCache();
                $this->info('✓ Settings cache cleared');
            }

            // Summary
            $this->newLine();
            $this->info('========================================');
            $this->info('  Bootstrap Summary');
            $this->info('========================================');
            $this->line("  Created:  {$created}");
            $this->line("  Updated:  {$updated}");
            $this->line("  Skipped:  {$skipped}");
            $this->info('========================================');
            $this->newLine();

            if ($skipped > 0 && ! $force) {
                $this->comment('💡 Tip: Use --force to update existing settings');
                $this->newLine();
            }

            $this->info('✓ Settings bootstrap completed successfully!');
            $this->newLine();

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->newLine();
            $this->error('Failed to bootstrap settings:');
            $this->error($e->getMessage());
            $this->newLine();

            return self::FAILURE;
        }
    }
}
