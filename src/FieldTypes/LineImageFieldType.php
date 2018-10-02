<?php

namespace Signifly\Travy\FieldTypes;

use Closure;
use Signifly\Travy\Action;

class LineImageFieldType extends FieldType
{
    protected $id = 'vLineImage';

    protected $actions = [];

    public function image($image)
    {
        return $this->addProp('image', $image);
    }

    public function noUpload()
    {
        return $this->addProp('imageUpload', false);
    }

    public function base64($base64)
    {
        return $this->addProp('imageBase64', $base64);
    }

    public function info($key, $value)
    {
        return $this->addProp('infoKey', $key)
            ->addProp('infoValue', $value);
    }

    public function title($key, $value)
    {
        return $this->addProp('titleKey', $key)
            ->addProp('titleValue', $value);
    }

    public function addAction($title, Closure $callable)
    {
        $action = new Action($title);

        $callable($action);

        $this->actions[] = $action->toArray();

        return $this;
    }

    protected function beforeBuild()
    {
        $this->addProp('actions', $this->actions);
    }
}
