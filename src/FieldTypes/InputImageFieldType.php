<?php

namespace Signifly\Travy\FieldTypes;

class InputImageFieldType extends FieldType
{
    protected $id = 'vInputImage';

    public function file($file)
    {
        return $this->addProp('file', $file);
    }

    public function url($url)
    {
        return $this->addProp('url', $url);
    }
}
