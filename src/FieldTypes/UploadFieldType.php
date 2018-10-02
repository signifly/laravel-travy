<?php

namespace Signifly\Travy\FieldTypes;

class UploadFieldType extends FieldType
{
    protected $id = 'vUpload';

    public function files($files)
    {
        return $this->addProp('files', $files);
    }

    public function fileTypes($fileTypes)
    {
        return $this->addProp('fileTypes', $fileTypes);
    }

    public function note($note)
    {
        return $this->addProp('note', $note);
    }
}
