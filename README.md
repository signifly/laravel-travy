# Define table and view json schemas for your Laravel app

The `signifly/laravel-travy` package allows you to define table and view json schemas for your Laravel app.

## Installation

You can install the package via composer:

```bash
$ composer require signifly/laravel-travy
```

The package will automatically register itself.

Add the routes to your `RouteServiceProvider` or routes file:
```php
use Signifly\Travy\Travy;

Travy::routes();
```

## Testing
```bash
$ composer test
```

## Security

If you discover any security issues, please email dev@signifly.com instead of using the issue tracker.

## Credits

- [Morten Poul Jensen](https://github.com/pactode)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
