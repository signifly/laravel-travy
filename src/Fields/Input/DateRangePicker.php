<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class DateRangePicker extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-date-range';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Set the dateEnd prop.
     *
     * @param  string $key
     * @return self
     */
    public function end(string $key): self
    {
        return $this->withProps(['dateEnd' => $key]);
    }

    /**
     * Set the format prop.
     *
     * @param  string $value
     * @return self
     */
    public function format(string $value): self
    {
        return $this->withProps(['format' => $value]);
    }

    /**
     * Set the formatValue prop.
     *
     * @param  string $value
     * @return self
     */
    public function formatValue(string $value): self
    {
        return $this->withProps(['formatValue' => $value]);
    }

    /**
     * Set the type prop.
     *
     * @param  string $type
     * @return self
     */
    public function type(string $type): self
    {
        return $this->withProps(compact('type'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['dateStart' => $this->attribute]);
    }
}
