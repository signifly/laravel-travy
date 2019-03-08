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
     * Indicates if the element should be shown on the index view.
     *
     * @var bool
     */
    public $showOnIndex = false;

    public function download(bool $value)
    {
        return $this->withProps(['download' => $value]);
    }

    public function height(string $val)
    {
        return $this->withProps(['height' => $value]);
    }

    public function upload(bool $value)
    {
        return $this->withProps(['upload' => $value]);
    }

    public function url(string $key)
    {
        return $this->withProps(['url' => $key]);
    }

    public function width(string $value)
    {
        return $this->withProps(['width' => $value]);
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
