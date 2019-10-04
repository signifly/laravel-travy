<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Support\UnmappedProp;
use Signifly\Travy\Schema\Concerns\CanDisable;

class Number extends Field
{
    use CanDisable;

    protected $propsValidationRules = [
        'disabled' => 'unmapped_prop:boolean',
        'unit' => 'unmapped_prop:string',
    ];

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-number';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = 0;

    /**
     * Set the unit prop.
     *
     * @param  string $unit
     * @return self
     */
    public function unit(string $unit): self
    {
        return $this->withProps(['unit' => new UnmappedProp($unit)]);
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['value' => $this->attribute]);
    }
}
