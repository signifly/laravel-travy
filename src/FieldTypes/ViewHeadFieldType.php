<?php

namespace Signifly\Travy\FieldTypes;

class ViewHeadFieldType extends FieldType
{
    protected $id = 'vViewHead';

    public function file($file)
    {
        return $this->addProp('file', $file);
    }

    public function image($image)
    {
        return $this->imageActive(true)->addProp('image', $image);
    }

    public function imageActive(bool $active)
    {
        return $this->addProp('imageActive', $active);
    }

    public function tag($tag)
    {
        return $this->addProp('tag', $tag);
    }

    public function title($title)
    {
        return $this->addProp('title', $title);
    }

    protected function beforeBuild()
    {
        if (! $this->hasProp('imageActive')) {
            $this->imageActive(false);
        }
    }
}
