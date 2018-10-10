<?php

namespace Signifly\Travy\Fields;

class Password extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'password';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;
}
