<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;
use Signifly\Travy\Schema\Concerns\HasOptions;

class Search extends Field
{
    use HasOptions;

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-search';

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps([
            'value' => $this->attribute,
            'options' => $this->options(),
        ]);
    }
}
