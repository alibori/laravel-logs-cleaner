<?php

namespace Alibori\LaravelLogsCleaner\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class LaravelLogsCleanerCommand extends Command
{
    public $signature = 'logs:clean {--force : Delete all log files without confirmation}';

    public $description = 'Command to delete logs';
    /**
     * @var array<string> $directories
     */
    private array $directories;

    public function handle(): int
    {
        $this->comment('Looking for logs to delete...');

        // Look for log files in the storage/logs directory
        $log_files = glob(storage_path('logs/*.log')) ?: [];

        // If logs directory has subdirectories, look for log files in them
        $this->directories = glob(storage_path('logs/*'), GLOB_ONLYDIR) ?: [];

        if (! empty($this->directories)) {
            foreach ($this->directories as $directory) {
                // Get substring after the last logs/ in the directory path
                $directory_name = substr($directory, strrpos($directory, '/') + 1);

                if (in_array($directory_name, (array)config('logs-cleaner.exclude_subdirectories', []))) {
                    continue;
                }

                $subdirectory_log_files = glob($directory.'/*.log') ?: [];

                $log_files = array_merge($log_files, $subdirectory_log_files);
            }
        }

        if (empty($log_files)) {
            $this->info('No logs found to delete!');

            return self::SUCCESS;
        }

        if ($this->option('force')) {
            foreach ($log_files as $log_file) {
                $this->deleteLogFile($log_file);
            }
        } else {
            $log_files = array_map(function ($log_file) {
                return basename($log_file);
            }, $log_files);

            $log_files = array_values($log_files);

            array_unshift($log_files, 'all');

            /** @var string $log_file */
            $log_file = $this->choice('Which log file do you want to delete?', $log_files, $log_files[0]);

            if ($log_file !== 'all') {
                $this->deleteLogFile($log_file);
            } else {
                // Delete 'all' index
                array_shift($log_files);

                foreach ($log_files as $log_file) {
                    $this->deleteLogFile($log_file);
                }
            }
        }

        $this->info('Logs deleted successfully!');

        return self::SUCCESS;
    }

    private function deleteLogFile(string $log_file): void
    {
        // Check if log file exists in base storage/logs directory
        if (file_exists(storage_path('logs/'.$log_file))) {
            unlink(storage_path('logs/'.$log_file));
        } else {
            // Check if log file exists in subdirectories
            if (! empty($this->directories)) {
                foreach ($this->directories as $directory) {
                    if (file_exists($directory.'/'.$log_file)) {
                        unlink($directory.'/'.$log_file);
                    }
                }
            }
        }
    }
}
