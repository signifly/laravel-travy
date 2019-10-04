<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Support\UnmappedProp;
use Signifly\Travy\Schema\Concerns\CanDisable;

class DateRangePicker extends Field
{
    use CanDisable;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-date-range';

    protected $propsValidationRules = [
        'clearable' => 'unmapped_prop:boolean',
        'disabled' => 'unmapped_prop:boolean',
        'format' => 'unmapped_prop:string',
        'formatValue' => 'unmapped_prop:string',
        'type' => 'unmapped_prop:string',
    ];

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
     * Set the clearable prop.
     *
     * @param  string $key
     * @return self
     */
    public function clearable(bool $value = true): self
    {
        return $this->withProps(['clearable' => new UnmappedProp($value)]);
    }

    /**
     * Set the format prop.
     *
     * @param  string $value
     * @return self
     */
    public function format(string $value): self
    {
        return $this->withProps(['format' => new UnmappedProp($value)]);
    }

    /**
     * Set the formatValue prop.
     *
     * @param  string $value
     * @return self
     */
    public function formatValue(string $value): self
    {
        return $this->withProps(['formatValue' => new UnmappedProp($value)]);
    }

    /**
     * Set the type prop.
     *
     * @param  string $type
     * @return self
     */
    public function type(string $type): self
    {
        return $this->withProps(['type' => new UnmappedProp($type)]);
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
