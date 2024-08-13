# Delete your Laravel project's logs files by command.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/alibori/laravel-logs-cleaner.svg?style=flat-square)](https://packagist.org/packages/alibori/laravel-logs-cleaner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/alibori/laravel-logs-cleaner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/alibori/laravel-logs-cleaner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/alibori/laravel-logs-cleaner/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/alibori/laravel-logs-cleaner/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/alibori/laravel-logs-cleaner.svg?style=flat-square)](https://packagist.org/packages/alibori/laravel-logs-cleaner)

Delete your Laravel project's logs files by running a command.

## Installation

You can install the package via composer:

```bash
composer require alibori/laravel-logs-cleaner
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="logs-cleaner-config"
```

This is the contents of the published config file:

```php
<?php

// config for Alibori/LaravelLogsCleaner
return [
    // Specify logs subdirectories to exclude from logs deletion
    'exclude_subdirectories' => [
        // 'custom-directory',
    ],
];
```

## Usage

Run `php artisan logs:clean` to delete all logs files in the `storage/logs` directory and subdirectories. You can exclude subdirectories by adding them to the `exclude_subdirectories` array in the config file.

You can use the `--force` option to skip the confirmation prompt.

```bash
php artisan logs:clean --force
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Axel Libori Roch](https://github.com/alibori)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
