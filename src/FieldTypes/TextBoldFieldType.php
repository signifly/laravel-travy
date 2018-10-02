<?php

namespace Signifly\Travy\FieldTypes;

class TextBoldFieldType extends FieldType
{
    protected $id = 'vTextBold';

    public function text($text)
    {
        return $this->addProp('text', $text);
    }

    public function textDefault($textDefault)
    {
        return $this->addProp('textDefault', $textDefault);
    }
}
