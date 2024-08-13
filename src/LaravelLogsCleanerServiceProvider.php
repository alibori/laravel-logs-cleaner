<?php

namespace Alibori\LaravelLogsCleaner;

use Alibori\LaravelLogsCleaner\Commands\LaravelLogsCleanerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLogsCleanerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-logs-cleaner')
            ->hasConfigFile()
            ->hasCommand(LaravelLogsCleanerCommand::class);
    }
}
