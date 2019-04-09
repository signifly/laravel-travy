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
     * The roles for viewing tables and dashboards.
     *
     * @var array
     */
    protected $roles = ['admin'];

    /**
     * Should the item be used as dashboard.
     *
     * @var bool
     */
    public $asDashboard = false;

    /**
     * Should the item be used as menu item.
     *
     * @var bool
     */
    public $asMenu = true;

    /**
     * Create a new item.
     *
     * @param string $name
     * @param string|null $attribute
     */
    public function __construct($name, $attribute = null)
    {
        $this->name = $name;
        $this->attribute = $attribute ?? str_replace(' ', '-', Str::lower($name));
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
     * Set the asDashboard property.
     *
     * @param  bool $value
     * @return self
     */
    public function asDashboard($value = true): self
    {
        $this->asMenu(false);
        $this->asDashboard = $value;

        return $this;
    }

    /**
     * Set the asMenu property.
     *
     * @param  bool $value
     * @return self
     */
    public function asMenu($value = true): self
    {
        $this->asMenu = $value;

        return $this;
    }

    /**
     * Set the item as table.
     *
     * @param  string $title
     * @param  string $key
     * @return self
     */
    public function asTable($title = null, $key = null): self
    {
        if ($title) {
            $this->tableTitle = $title;
            $this->tableKey = $key ?? str_replace(' ', '-', Str::lower($title));

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
    public function children(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Check if it has any items.
     *
     * @return bool
     */
    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }

    /**
     * Check it it has table properties.
     *
     * @return bool
     */
    public function hasTable(): bool
    {
        return $this->tableTitle && $this->tableKey;
    }

    /**
     * Get the items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function items(): Collection
    {
        return collect($this->items)->filter(function ($item) {
            return $item->asMenu;
        })->values();
    }

    /**
     * Set the link.
     *
     * @param  string $link
     * @return self
     */
    public function link(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Set the roles.
     *
     * @param  array  $roles
     * @return self
     */
    public function roles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Return dashboard schema.
     *
     * @return array
     */
    public function toDashboard(): array
    {
        return [$this->attribute => [
            'title' => __($this->name),
            'auth' => ['roles' => $this->roles],
        ]];
    }

    /**
     * Return menu schema.
     *
     * @return array
     */
    public function toMenu(): array
    {
        $data = [
            'title' => __($this->name),
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
    public function toTable(): array
    {
        return [$this->tableKey => [
            'title' => __($this->tableTitle),
            'auth' => ['roles' => $this->roles],
        ]];
    }
}
