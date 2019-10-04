<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Support\UnmappedProp;
use Signifly\Travy\Schema\Concerns\CanDisable;

class Precision extends Field
{
    use CanDisable;

    protected $propsValidationRules = [
        'disabled' => 'unmapped_prop:boolean',
        'max' => 'unmapped_prop:numeric',
        'precision' => 'unmapped_prop:integer',
        'step' => 'unmapped_prop:numeric',
    ];

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-precision';

    /**
     * The default value for the field.
     *
     * @var mixed
     */
    public $defaultValue = 0;

    /**
     * Set the max prop.
     *
     * @param  float  $value
     * @return self
     */
    public function max(float $value): self
    {
        return $this->withProps(['max' => new UnmappedProp($value)]);
    }

    /**
     * Set the precision prop.
     *
     * @param  int    $value
     * @return self
     */
    public function precision(int $value): self
    {
        return $this->withProps(['precision' => new UnmappedProp($value)]);
    }

    /**
     * Set the step prop.
     *
     * @param  float  $value
     * @return self
     */
    public function step(float $value): self
    {
        return $this->withProps(['step' => new UnmappedProp($value)]);
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
