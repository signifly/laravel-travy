<?php

namespace Signifly\Travy\Fields;

use JsonSerializable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Signifly\Travy\Schema\Width;
use Signifly\Travy\Schema\Concerns\HasProps;
use Signifly\Travy\Schema\Concerns\HasMetaData;

abstract class Field extends FieldElement implements JsonSerializable
{
    use HasProps;
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
     * Indicates if the field should be displayed
     * as a text component in the table.
     *
     * @var bool
     */
    public $displayAsText = false;

    /**
     * The validation rules for creation and updates.
     *
     * @var array
     */
    public $rules = [];

    /**
     * The validation rules for creation.
     *
     * @var array
     */
    public $creationRules = [];

    /**
     * Indicates if the field should be linkable.
     *
     * @var bool
     */
    public $linkable = false;

    /**
     * The endpoint to link to.
     *
     * @var string
     */
    public $linksTo;

    /**
     * Should the field be used as the batch label.
     *
     * @var bool
     */
    public $isBatchLabel = false;

    /**
     * Should the field be used as the header image in views.
     *
     * @var bool
     */
    public $isHeaderImage = false;

    /**
     * Should the field be used as the header title in views.
     *
     * @var bool
     */
    public $isHeaderTitle = false;

    /**
     * Indicates if the field should be searchable.
     *
     * @var bool
     */
    public $searchable = false;

    /**
     * The validation rules for updates.
     *
     * @var array
     */
    public $updateRules = [];

    /**
     * Indicates if the field should be sortable.
     *
     * @var bool
     */
    public $sortable = false;

    /**
     * Indicates if the field is the default sortable.
     *
     * @var bool
     */
    public $defaultSort = false;

    /**
     * Indicates if the field is the default sortable.
     *
     * @var bool
     */
    public $defaultSortOrder = 'ascending';

    /**
     * The attribute to sort by.
     *
     * @var string
     */
    public $sortBy;

    /**
     * The width configuration.
     *
     * @var \Signifly\Travy\Schema\Width
     */
    public $width;

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
     * Set the isBatchLabel property.
     *
     * @param  bool $value
     * @return self
     */
    public function batchLabel($value = true): self
    {
        $this->isBatchLabel = $value;

        return $this;
    }

    /**
     * Set the isHeaderImage property.
     *
     * @param  bool $value
     * @return self
     */
    public function headerImage($value = true): self
    {
        $this->headerImage = $value;

        return $this;
    }

    /**
     * Set the isHeaderTitle property.
     *
     * @param  bool $value
     * @return self
     */
    public function headerTitle($value = true): self
    {
        $this->isHeaderTitle = $value;

        return $this;
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
     * Set the validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return self
     */
    public function rules($rules): self
    {
        $this->rules = is_string($rules) ? func_get_args() : $rules;

        return $this;
    }

    /**
     * Get the validation rules for this field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getRules(Request $request): array
    {
        return [$this->attribute => is_callable($this->rules)
                            ? call_user_func($this->rules, $request)
                            : $this->rules, ];
    }

    /**
     * Get the creation rules for this field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|string
     */
    public function getCreationRules(Request $request)
    {
        $rules = [$this->attribute => is_callable($this->creationRules)
                            ? call_user_func($this->creationRules, $request)
                            : $this->creationRules, ];

        return array_merge_recursive(
            $this->getRules($request), $rules
        );
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return self
     */
    public function creationRules($rules): self
    {
        $this->creationRules = is_string($rules) ? func_get_args() : $rules;

        return $this;
    }

    /**
     * Get the update rules for this field.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getUpdateRules(Request $request)
    {
        $rules = [$this->attribute => is_callable($this->updateRules)
                            ? call_user_func($this->updateRules, $request)
                            : $this->updateRules, ];

        return array_merge_recursive(
            $this->getRules($request), $rules
        );
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param  callable|array|string  $rules
     * @return self
     */
    public function updateRules($rules): self
    {
        $this->updateRules = is_string($rules) ? func_get_args() : $rules;

        return $this;
    }

    /**
     * Specify that this field should be linkable.
     *
     * @param  bool $value
     * @param  string  $uri
     * @return self
     */
    public function linkable($value = true, $uri = null): self
    {
        $this->linkable = $value;
        $this->linksTo = $uri;

        return $this;
    }

    /**
     * Specify that this field should be searchable.
     *
     * @param  bool  $value
     * @return self
     */
    public function searchable($value = true): self
    {
        $this->searchable = $value;

        return $this;
    }

    /**
     * Specify that this field should be sortable.
     *
     * @param  bool  $value
     * @return self
     */
    public function sortable($value = true, $attribute = null): self
    {
        $this->sortable = $value;
        $this->sortBy = $attribute ?? $this->attribute;

        return $this;
    }

    /**
     * Specify that this field is default sort.
     *
     * @param  bool $value
     * @return self
     */
    public function defaultSort($value = true, $order = 'asc'): self
    {
        $this->defaultSort = $value;
        $this->defaultSortOrder = ($order == 'asc' ? 'ascending' : 'descending');

        return $this;
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
     * Specify the field column width.
     * - it overwrites the `width` prop and is only used for tables
     *
     * @param  int    $value
     * @return self
     */
    public function columnWidth(int $value): self
    {
        return $this->withMeta(['columnWidth' => $value]);
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
     * Specify the field tooltip text.
     *
     * @param  string $text
     * @return self
     */
    public function tooltip(string $text): self
    {
        return $this->withMeta(['tooltip' => $text]);
    }

    /**
     * Specify the field width.
     *
     * @param  int    $value
     * @return self
     */
    public function width(int $value, ?Closure $callable = null): self
    {
        $width = new Width($value);

        if (! is_null($callable)) {
            $callable($width);
        }

        $this->width = $width;

        return $this;
    }

    public function fieldType(): array
    {
        $data = [
            'id' => $this->component,
            'props' => $this->props(),
        ];

        return $data;
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

        if ($this->linkable) {
            $this->withMeta(['onClick' => $this->linksTo]);
        }

        return array_merge([
            'name' => $this->attribute,
            'label' => $this->name,
            'fieldType' => $this->fieldType(),
        ], $this->meta());

        return $data;
    }
}
