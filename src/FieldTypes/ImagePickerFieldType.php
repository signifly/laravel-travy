<?php

namespace Signifly\Travy\FieldTypes;

class ImagePickerFieldType extends FieldType
{
    protected $id = 'vImagePicker';

    public function id($id)
    {
        return $this->addProp('id', $id);
    }

    public function options(array $options)
    {
        return $this->addProp('options', $options);
    }

    public function url($url)
    {
        return $this->addProp('url', $url);
    }
}
