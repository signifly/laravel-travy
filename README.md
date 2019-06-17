# Laravel Travy - A Modular Vue-based Administration Tool

The `signifly/laravel-travy` package allows you to configure an administration tool using code driven configuration.

## Official Documentation

Documentation for Travy can be found [here](https://signifly.gitbook.io/laravel-travy/).

## Installation

To get started install the package via Composer:

```bash
composer require signifly/laravel-travy
```

The package will automatically register itself.

Add the routes to your `RouteServiceProvider` or routes file:

```php
use Signifly\Travy\Travy;

Travy::routes();
```

*NOTE: The package is in beta. It is not recommended for public usage as the features may change frequently.*

## Testing

```bash
composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
