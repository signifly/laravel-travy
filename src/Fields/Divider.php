<?php

namespace Signifly\Travy\Fields;

use Illuminate\Support\Str;

class Divider extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'divider';

    /**
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = null;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));

        $this->text($name);
    }

    /**
     * Set the text prop.
     *
     * @param  string $text
     * @return self
     */
    public function text(string $text): self
    {
        return $this->withProps(['text' => __($text)]);
    }
}
