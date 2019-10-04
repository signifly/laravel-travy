<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Concerns\CanDisable;

class Password extends Field
{
    use CanDisable;

    protected $propsValidationRules = [
        'disabled' => 'unmapped_prop:boolean',
    ];

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-password';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

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
