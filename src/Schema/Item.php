<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Item
{
    /**
     * The displayable name of the field.
     *
     * @var string
     */
    protected $name;

    /**
     * The attribute / column name of the field.
     *
     * @var string
     */
    protected $attribute;

    /**
     * The menu link.
     *
     * @var string|null
     */
    protected $link = null;

    /**
     * The displayable title of the table.
     *
     * @var string
     */
    protected $tableTitle;

    /**
     * The key of the table.
     *
     * @var string
     */
    protected $tableKey;

    /**
     * The children items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Create a new item.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '_', Str::lower($name));
    }

    /**
     * Static helper to make a new item.
     *
     * @return static
     */
    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Set the item as table.
     *
     * @param  string $title
     * @param  string $key
     * @return self
     */
    public function asTable($title = null, $key = null)
    {
        if ($title) {
            $this->tableTitle = $title;
            $this->tableKey = $key ?? str_replace(' ', '_', Str::lower($title));
            return $this;
        }

        $this->tableTitle = $this->name;
        $this->tableKey = $key ?? $this->attribute;

        return $this;
    }

    /**
     * Set the children of the item.
     *
     * @param  array  $items
     * @return self
     */
    public function children(array $items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Check if it has any items.
     *
     * @return bool
     */
    public function hasItems() : bool
    {
        return count($this->items) > 0;
    }

    /**
     * Check it it has table properties.
     *
     * @return bool
     */
    public function hasTable() : bool
    {
        return $this->tableTitle && $this->tableKey;
    }

    /**
     * Get the items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function items() : Collection
    {
        return collect($this->items);
    }

    /**
     * Set the link.
     *
     * @param  string $link
     * @return self
     */
    public function link(string $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Return menu schema.
     *
     * @return array
     */
    public function toMenu() : array
    {
        $data = [
            'title' => $this->name,
            'link' => $this->link ?? "/t/{$this->attribute}",
        ];

        $items = $this->items()
            ->map->toMenu()
            ->toArray();

        return $this->hasItems() ? $data + compact('items') : $data;
    }

    /**
     * Return table schema.
     *
     * @return array
     */
    public function toTable() : array
    {
        return [$this->tableKey => [
            'title' => $this->tableTitle,
            'auth' => ['roles' => ['admin']],
        ]];
    }
}
