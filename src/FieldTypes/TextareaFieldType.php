<?php

namespace Signifly\Travy\FieldTypes;

class TextareaFieldType extends FieldType
{
    protected $id = 'vTextarea';

    public function text($text)
    {
        return $this->addProp('text', $text);
    }
}
