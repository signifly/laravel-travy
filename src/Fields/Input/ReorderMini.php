<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Concerns\HasOptions;
use Signifly\Travy\Schema\Concerns\HasEndpoint;

class ReorderMini extends Field
{
    use HasOptions;
    use HasEndpoint;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-reorder-mini';

    /**
     * Set the `columns` prop.
     *
     * @param  array<key, label>  $columns
     * @return self
     */
    public function columns(array $columns): self
    {
        return $this->withProps(compact('columns'));
    }

    /**
     * Set the `options.key` prop.
     *
     * @param  string $key
     * @return self
     */
    public function key(string $key): self
    {
        return $this->withOptions(compact('key'));
    }

    /**
     * Set the `options.value` prop.
     *
     * @param  string $value
     * @return self
     */
    public function value(string $value): self
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
            'prop' => $this->attribute,
            'options' => $this->options(),
        ]);
    }
}
