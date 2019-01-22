<?php

namespace Signifly\Travy\Fields\Input;

use Closure;
use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Schema\Concerns\HasOptions;

class SelectSearch extends Field
{
    use HasOptions;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-select-search';

    /** @var \Signifly\Travy\Schema\Endpoint */
    public $endpoint;

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Set the addable prop.
     *
     * @param  bool $value
     * @return self
     */
    public function addable($value = true)
    {
        return $this->withProps(['addable' => $value]);
    }

    /**
     * Set the clearable prop.
     *
     * @param  bool $value
     * @return self
     */
    public function clearable($value = true)
    {
        return $this->withProps(['clearable' => $value]);
    }

    /**
     * The default options for the element.
     *
     * @return array
     */
    public function defaultOptions(): array
    {
        return [
            'key' => 'data',
            'itemKey' => 'data',
            'value' => 'id',
        ];
    }

    /**
     * Set the endpoint option.
     *
     * @param  string $url
     * @param  array  $params
     * @return self
     */
    public function endpoint(string $url, ?Closure $callback = null): self
    {
        $endpoint = new Endpoint($url);

        if (! is_null($callable)) {
            $callable($endpoint);
        }

        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the itemKey option.
     *
     * @param  string $itemKey
     * @return self
     */
    public function itemKey(string $itemKey)
    {
        return $this->withOptions(compact('itemKey'));
    }

    /**
     * Set the key option.
     *
     * @param  string $key
     * @return self
     */
    public function key(string $key)
    {
        return $this->withOptions(compact('key'));
    }

    /**
     * Set the label option.
     *
     * @param  string $label
     * @return self
     */
    public function label(string $label)
    {
        return $this->withOptions(compact('label'));
    }

    /**
     * Set the value option.
     *
     * @param  string $value
     * @return self
     */
    public function value(string $value)
    {
        return $this->withOptions(compact('value'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        if ($this->endpoint) {
            $this->withOptions(['endpoint' => $this->endpoint->toArray()]);
        }

        $this->withProps([
            'value' => $this->attribute,
            'options' => $this->options(),
        ]);
    }
}
