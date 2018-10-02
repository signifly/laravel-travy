<?php

namespace Signifly\Travy\FieldTypes;

class TextFieldType extends FieldType
{
    protected $id = 'vText';

    /**
     * Add a text prop.
     *
     * @param  string $value
     * @return self
     */
    public function text(string $value)
    {
        return $this->addProp('text', $value);
    }

    /**
     * Add a textDefault prop.
     *
     * @param  string $value
     * @return self
     */
    public function textDefault(string $value)
    {
        return $this->addProp('textDefault', $value);
    }
}
