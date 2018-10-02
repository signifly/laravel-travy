<?php

namespace Signifly\Travy\FieldTypes;

class ReorderFieldType extends FieldType
{
    protected $id = 'vReorder';

    protected $columns = [];

    public function items($items)
    {
        return $this->addProp('items', $items);
    }

    public function itemsKey($itemsKey)
    {
        return $this->addProp('itemsKey', $itemsKey);
    }

    public function itemsValue($itemsValue)
    {
        return $this->addProp('itemsValue', $itemsValue);
    }

    public function endpoint($url, $method = 'get')
    {
        return $this->addProp('endpoint', compact('url', 'method'));
    }

    public function addColumn($key, $label)
    {
        $this->columns[] = compact('key', 'label');

        return $this;
    }

    protected function beforeBuild()
    {
        $this->addProp('columns', $this->columns);
    }
}
