# Laravel Travy - A modular vue-based administration tool

The `signifly/laravel-travy` package allows you to configure an administration tool using code driven configuration. It works entirely as a standalone API that needs to be associated with the Vue SPA equivalent package.

You can find the npm package for the Vue SPA [here](https://www.npmjs.com/package/@signifly/travy).

## Table of Contents
* [Installation](#installation)
* [Resources](#resources)
  * [Defining resources](#defining-resources)
  * [Resolve resource binding](#resolve-resource-binding)
* [Commands](#commands)
* [Fields](#fields)
  * [Date](#date)
  * [Text](#text)

## Documentation

Travy has a few requirements:
* Composer
* Laravel Framework 5.8+

In addition, Travy has a few dependencies that you can use as you like:
* [signifly/laravel-api-responder](https://github.com/signifly/laravel-api-responder)
* [signifly/laravel-builder-macros](https://github.com/signifly/laravel-builder-macros)
* [signifly/laravel-pagination-middleware](https://github.com/signifly/laravel-pagination-middleware)
* [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog)
* [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder)
* [waavi/sanitizer](https://github.com/waavi/sanitizer)

### Installation

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

### Resources

The primary feature of Travy is to update your database records using Eloquent. This is done by creating Travy "resources" that contains actions, fields, filters and modifiers.

#### Defining Resources

By default, Travy resources are stored within the `App\Travy` namespace. You can modify this in the config file: `config/travy.php`. To get started, you may generate a resource using the `travy:resource` command:

```bash
php artisan travy:resource User
```

The resource will try to guess the Eloquent model that it corresponds to by looking for a model with the same name within the `App\Models` namespace, which can be modified in the `config/travy.php` file. If you want to tell Travy, which Eloquent model the resource corresponds, you may do that using the `$model` property on the resource:

```php
/**
 * The model the resource corresponds to.
 * 
 * @var string
 */
protected $model = 'App\Models\User';
```

#### Resolve resource binding

Travy comes with basic crud features of the box. If you want to overwrite how a resource is resolved using the Travy request, one can do that by defining the `resolveResourceBinding` method on the model.

```php
public function resolveResourceBinding($value)
{
    return $this->where('code', $value)->firstOrFail();
}
```

#### Eager loading

If you need to access a resource's relationships within your fields, it may be a good idea to eager load those relationships using the `$includes` and `$with` properties.

```php
/**
 * The relationships that are eager loaded on index actions.
 * 
 * @var array
 */
protected $includes = [

];

/**
 * The relationships that are eager loaded on show actions.
 * 
 * @var array
 */
protected $with = [
    'roles',
];
```

### Commands

Travy comes along with a range of commands, that makes it easier to generate actions, definitions and resources.

**Actions**

```bash
php artisan travy:action UserStoreAction
```

**Dashboards**

```bash
php artisan travy:dashboard OverviewDashboard
```

**Resources**

```bash
php artisan travy:resource User
```

**Tables**

You can overwrite the default table or create custom tables by using the following command:

```bash
php artisan travy:table UserTable
```

*NOTE: The naming convention is the resource's name in singular with the Table suffix.*

**Views**

You can overwrite the default view for a resource by using the following command:

```bash
php artisan travy:view UserView
```

*NOTE: The naming convention is the resource's name in singular with the View suffix.*

### Fields

The available fields live within the `Signifly\Travy\Fields` namespace.

#### Date

```php
use Signifly\Travy\Fields\Date;

Date::make('Created at');
```

#### Text

```php
use Signifly\Travy\Fields\Text;

Text::make('Name', 'attribute');
```

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
