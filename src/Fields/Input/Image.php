<?php

namespace Signifly\Travy\Fields\Input;

use Signifly\Travy\Fields\Field;

class Image extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'input-image';

    /**
     * Set the download prop.
     *
     * @param  bool   $value
     * @return self
     */
    public function download(bool $value): self
    {
        return $this->withProps(['download' => $value]);
    }

    /**
     * Set the upload prop.
     *
     * @param  bool   $value
     * @return self
     */
    public function upload(bool $value): self
    {
        return $this->withProps(['upload' => $value]);
    }

    /**
     * Set the url prop.
     *
     * @param  string $url
     * @return self
     */
    public function url(string $url): self
    {
        return $this->withProps(compact('url'));
    }

    /**
     * Set the width and height props.
     *
     * @param  string $width  defaults to '160px'
     * @param  string $height defaults to '160px'
     * @return self
     */
    public function size(string $width = '160px', string $height = '160px'): self
    {
        return $this->withProps(compact('width', 'height'));
    }

    /**
     * The options to apply to the field type.
     *
     * @return void
     */
    public function applyOptions()
    {
        $this->withProps(['file' => $this->attribute]);
    }
}
