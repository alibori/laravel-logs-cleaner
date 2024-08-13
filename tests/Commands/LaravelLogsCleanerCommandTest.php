<?php

it('command deletes all logs when --force option is passed and exists logs', function () {
    // Create a log file
    file_put_contents(storage_path('logs/laravel.log'), 'Log content');

    // Assert file exists
    $this->assertFileExists(storage_path('logs/laravel.log'));

    $this->artisan('logs:clean --force')
        ->expectsOutput('Logs deleted successfully!');
});

it('command deletes all logs', function () {
    // Create a log file
    file_put_contents(storage_path('logs/laravel.log'), 'Log content');

    $this->artisan('logs:clean')
        ->expectsQuestion('Which log file do you want to delete?', 'all')
        ->expectsOutput('Logs deleted successfully!');

    // Assert that the log file was deleted
    $this->assertFileDoesNotExist(storage_path('logs/laravel.log'));
});

it('command deletes a specific log file', function () {
    // Create a log files
    file_put_contents(storage_path('logs/laravel.log'), 'Log content');
    file_put_contents(storage_path('logs/custom.log'), 'Log content');

    $this->artisan('logs:clean')
        ->expectsQuestion('Which log file do you want to delete?', 'laravel.log')
        ->expectsOutput('Logs deleted successfully!');

    // Assert that the log file was deleted
    $this->assertFileDoesNotExist(storage_path('logs/laravel.log'));

    // Assert that the log file was not deleted
    $this->assertFileExists(storage_path('logs/custom.log'));
});

it('command delete logs excluding subdirectories', function () {
    // Create a log files
    file_put_contents(storage_path('logs/laravel.log'), 'Log content');

    // Create a custom subdirectory in logs directory if it does not exist
    if (! is_dir(storage_path('logs/custom'))) {
        mkdir(storage_path('logs/custom'));
    }

    // Create a log file in custom subdirectory
    file_put_contents(storage_path('logs/custom/custom.log'), 'Log content');

    // Add custom subdirectory to exclude from logs deletion
    config(['logs-cleaner.exclude_subdirectories' => ['custom']]);

    $this->artisan('logs:clean')
        ->expectsQuestion('Which log file do you want to delete?', 'all')
        ->expectsOutput('Logs deleted successfully!');

    // Assert that the log file was deleted
    $this->assertFileDoesNotExist(storage_path('logs/laravel.log'));

    // Assert that the log file was not deleted
    $this->assertFileExists(storage_path('logs/custom/custom.log'));

    // Clean up
    unlink(storage_path('logs/custom/custom.log'));
});

it('command does not delete logs when no logs are found', function () {
    $this->artisan('logs:clean')
        ->expectsOutput('No logs found to delete!');
});
