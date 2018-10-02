<?php

namespace Signifly\Travy;

class MenuItem
{
    protected $title;

    protected $slug;

    protected $items = [];

    /**
     * Create a new MenuItem instance.
     *
     * @param string $title
     * @param string|null $slug
     */
    public function __construct(string $title, $slug = null)
    {
        $this->title = $title;
        $this->slug = $slug;
    }

    /**
     * Add item to menu item.
     *
     * @param MenuItem $item
     */
    public function addChild(MenuItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    public function getSlug()
    {
        if (! $this->slug) {
            return str_slug($this->title);
        }

        return $this->slug;
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }

    public function link()
    {
        return "/t/{$this->getSlug()}";
    }

    public function toArray()
    {
        $data = collect([
            'title' => $this->title,
        ]);

        if ($this->hasItems()) {
            $items = collect($this->items)->map->toArray();
            $data->put('items', $items->all());
            return $data->toArray();
        }

        $data->put('link', $this->link());

        return $data->toArray();
    }

    public function toTable()
    {
        return [
            $this->getSlug() => [
                'title' => $this->title,
                'auth' => ['roles' => ['admin']],
            ],
        ];
    }
}
