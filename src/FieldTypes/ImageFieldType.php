<?php

namespace Signifly\Travy\FieldTypes;

class ImageFieldType extends FieldType
{
    protected $id = 'vImage';

    public function image($image)
    {
        return $this->addProp('image', $image);
    }
}
