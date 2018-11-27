<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Concerns\HasOptions;

class Select extends Field
{
    use HasOptions;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-select';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

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
     * Set the items prop.
     *
     * @param  string $items
     * @return self
     */
    public function items(string $items)
    {
        return $this->withProps(compact('items'));
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
        $this->withProps([
            'value' => $this->attribute,
            'options' => $this->options(),
        ]);
    }
}
