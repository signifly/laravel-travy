<?php

namespace Signifly\Travy\Fields;

use JsonSerializable;
use Illuminate\Support\Str;
use Signifly\Travy\Schema\Width;
use Signifly\Travy\Support\PropsResolver;
use Signifly\Travy\Support\ScopesApplier;
use Signifly\Travy\Schema\Concerns\HasProps;
use Signifly\Travy\Schema\Concerns\HasScopes;
use Signifly\Travy\Support\AttributeResolver;
use Signifly\Travy\Schema\Concerns\HasMetaData;

abstract class Field extends FieldElement implements JsonSerializable
{
    use HasProps;
    use HasScopes;
    use HasMetaData;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component;

    /**
     * The displayable name of the field.
     *
     * @var string
     */
    public $name;

    /**
     * The attribute / column name of the field.
     *
     * @var string
     */
    public $attribute;

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = null;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Create a new element.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Create a field without a name.
     *
     * @param  string $attribute
     * @return static
     */
    public static function attr($attribute)
    {
        return static::make(null, $attribute);
    }

    /**
     * Set the Vue component name.
     *
     * @param  string $component
     * @return self
     */
    public function component(string $component): self
    {
        $this->component = $component;

        return $this;
    }

    /**
     * Check if what component the field is.
     *
     * @param  string  $component
     * @return bool
     */
    public function is(string $component): bool
    {
        return $this->component == $component;
    }

    /**
     * Hide action on given constraint.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $operator
     * @return self
     */
    public function hide(string $key, $value, string $operator = 'eq'): self
    {
        return $this->withMeta(['hide' => compact('key', 'operator', 'value')]);
    }

    /**
     * Specify that this field should be disabled.
     *
     * @param  bool  $value
     * @return self
     */
    public function disabled($value = true): self
    {
        return $this->withProps(['disabled' => $value]);
    }

    /**
     * Specify the url the field should link to.
     *
     * @param  string $url
     * @return self
     */
    public function onClick(string $url): self
    {
        return $this->withMeta(['onClick' => $url]);
    }

    /**
     * Set the default value of the field.
     *
     * @param  mixed $value
     * @return self
     */
    public function defaultValue($value): self
    {
        $this->defaultValue = $value;

        return $this;
    }

    /**
     * Specify the field description.
     *
     * @param  string $text
     * @return self
     */
    public function description(string $text): self
    {
        return $this->withMeta(['description' => $text]);
    }

    /**
     * Set the sublabel of the column.
     *
     * @param  string $text
     * @return self
     */
    public function sublabel(string $text): self
    {
        return $this->withMeta(['sublabel' => $text]);
    }

    /**
     * Specify the field width.
     *
     * @param  int    $value
     * @return self
     */
    public function width(int $value): self
    {
        return $this->withMeta(['width' => $value]);
    }

    /**
     * The field type.
     *
     * @return array
     */
    public function fieldType(): array
    {
        $props = $this->props();

        // Guard against invalid props *before* transforming (mapped/unmapped and scoping) them...
        $this->guardAgainstInvalidProps($props);

        return [
            'id' => $this->component,
            'props' => $this->transformProps($props),
        ];
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        if (method_exists($this, 'applyOptions')) {
            $this->applyOptions();
        }

        return array_merge([
            'name' => $this->localize($this->name),
            'attribute' => (new AttributeResolver())->resolve($this->attribute, $this->name),
            'fieldType' => $this->fieldType(),
        ], $this->meta());
    }

    protected function transformProps(array $props): array
    {
        return (new PropsResolver())->resolve(
            (new ScopesApplier())->apply($props, $this->scopes())
        );
    }
}
