# Laravel Travy - A Modular Vue-based Administration Tool

The `signifly/laravel-travy` package allows you to configure an administration tool using code driven configuration. It works entirely as a standalone API that needs to be associated with the Vue SPA equivalent package.

You can find the npm package for the Vue SPA [here](https://www.npmjs.com/package/@signifly/travy).

## Table of Contents
* [Installation](#installation)
* [Resources](#resources)
  * [Defining resources](#defining-resources)
  * [Resolve resource binding](#resolve-resource-bindings)
  * [Eager Loading](#eager-loading)
* [Actions](#actions)
  * [Custom Actions](#custom-actions)
  * [Generating Actions](#generating-actions)
  * [Retrieving Input](#retrieving-input)
  * [Working with Eloquent](#working-with-eloquent)
* [Fields](#fields)
  * [Date Field](#date-field)
  * [Divider Field](#divider-field)
  * [ImageHover Field](#imagehover-field)
  * [Status Field](#status-field)
  * [Text Field](#text-field)
* [Filters](#filters)
* [Modifiers](#modifiers)

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

*NOTE: The package is in beta. It is not recommended for public usage as the features may change frequently.*

### Resources

The primary feature of Travy is to update your database records using Eloquent. This is done by creating Travy "resources" that contains [actions](#actions), [fields](#fields), [filters](#filters) and [modifiers](#modifiers).

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

#### Resolve Resource Bindings

Travy comes with basic crud features of the box. If you want to overwrite how a resource is resolved using the Travy request, one can do that by defining the `resolveResourceBinding` method on the model.

```php
public function resolveResourceBinding($value)
{
    return $this->where('code', $value)->firstOrFail();
}
```

#### Eager Loading

If you need to access a resource's relationships within your fields, it may be a good idea to eager load those relationships using the `$includes` and `$with` properties.

```php
/**
 * The relationships that are eager loaded on index actions.
 * 
 * @var array
 */
protected $includes = [
    'roles',
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

### Actions

A resource's actions are called whenever you make a request to its associated endpoints. For instance, if you have a `Product` resource the actions list will look as below:

* IndexAction - `GET /v1/admin/products`
* ShowAction - `GET /v1/admin/products/1`
* StoreAction - `POST /v1/admin/products`
* UpdateAction - `PUT /v1/admin/products/1`
* DestroyAction - `DELETE /v1/admin/products/1`

If a model is soft deletable, the following actions are also available:

* RestoreAction - `POST /v1/admin/products/1/restore`
* ForceDestroyAction - `DELETE /v1/admin/products/1/force`

#### Custom Actions

You may overwrite the actions for a resource, by defining them within the `actions()` method on the resource.

```php
/**
 * The actions that should be merged with the default actions.
 *
 * @return array
 */
protected function actions(): array
{
    return [
        'index' => CustomIndexAction::class,
    ];
}
```

#### Generating Actions

In order to create a custom action, you may use the `travy:action` command:

```bash
php artisan travy:action CustomIndexAction
```

The generated actions will by default be located within the `App\Travy\Http\Actions` namespace. This is configurable in the `config/travy.php` file.

#### Retrieving Input

The request data are sent within the `data` input key. To easily work with the input, you may use the `Signifly\Travy\Support\Input` instance within the action. The following methods are available:

```php
// Retrieve raw input
$this->input->data();

// Retrieve all input
$this->input->all();

// Retrieve a specific input key
$this->input->get('username');

// Check if the input has a given key
$this->input->has('password');

// Retrieve a specific set of keys
$this->input->only('username', 'password');

// Retrieve all input except a specified set of keys
$this->input->except('password');

// Retrieve a specific key as a Illuminate\Support\Collection
$this->input->collect('items');
```

#### Working with Eloquent

The action instance is constructed by the `Request` and `Resource`. Retrieving the model resolved from the request can be achieved via the resource:

```php
// Example: The default UpdateAction
use Illuminate\Contracts\Support\Responsable;

class UpdateAction extends Action
{
    public function handle(): Responsable
    {
        $model = $this->resource->model();

        $model->update($this->input->all());

        return $this->respond(
            $model->fresh($this->resource->with())
        );
    }
}
```

### Fields

The available fields live within the `Signifly\Travy\Fields` namespace.

#### Date Field

```php
Date::make('Created at');
```

#### Divider Field

```php
Divider::attr('attributes_divider')
    ->text('Attributes');
```

#### ImageHover Field

```php
ImageHover::make('Image', 'image_url');
```

#### Status Field

```php
Status::make('Role')
    ->color('primary');
```

#### Text Field

```php
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
