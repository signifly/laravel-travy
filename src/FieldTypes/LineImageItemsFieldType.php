<?php

namespace Signifly\Travy\FieldTypes;

use Closure;
use Signifly\Travy\Schema\Action;

class LineImageItemsFieldType extends FieldType
{
    protected $id = 'vLineImageItems';

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

    public function items($items)
    {
        return $this->addProp('items', $items);
    }

    public function itemKey($itemKey)
    {
        return $this->addProp('itemKey', $itemKey);
    }

    public function itemValue($itemValue)
    {
        return $this->addProp('itemValue', $itemValue);
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
