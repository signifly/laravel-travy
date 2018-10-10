<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Collection;

class Menu extends Collection
{
    public function addItem(string $title, $slug = null)
    {
        $item = new MenuItem($title, $slug);

        $this->push($item);

        return $item;
    }

    public function build()
    {
        return $this->map(function ($item) {
            return $item->toArray();
        })->all();
    }

    public function toTable()
    {
        return $this->flatMap(function ($item) {
            return $item->toTable();
        })->all();
    }
}
