<?php

namespace Signifly\Travy\Fields;

class Image extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'image';

    /**
     * Set the fit prop.
     *
     * @param  string $fit It should be either `contain` or `cover`.
     * @return self
     */
    public function fit(string $fit): self
    {
        return $this->withProps(compact('fit'));
    }

    /**
     * Set the width and height props.
     *
     * @param  string $width
     * @param  string $height
     * @return self
     */
    public function size(string $width = '200px', string $height = '200px'): self
    {
        return $this->withProps(compact('width', 'height'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions(): void
    {
        $this->withProps(['src' => $this->attribute]);
    }
}
