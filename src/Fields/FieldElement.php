<?php

namespace Signifly\Travy\Fields;

abstract class FieldElement
{
    /**
     * Localize text.
     *
     * @param  mixed $text
     * @return mixed
     */
    protected function localize($text)
    {
        return is_string($text) ? __($text) : $text;
    }
}
