<?php

namespace Signifly\Travy\FieldTypes;

class InputFileFieldType extends FieldType
{
    protected $id = 'vInputFile';

    public function file($file)
    {
        return $this->addProp('file', $file);
    }

    public function fileTypes($fileTypes)
    {
        return $this->addProp('fileTypes', $fileTypes);
    }

    public function note($note)
    {
        return $this->addProp('note', $note);
    }

    public function url($url)
    {
        return $this->addProp('url', $url);
    }
}
