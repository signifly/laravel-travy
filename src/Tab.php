<?php

namespace Signifly\Travy;

use Closure;
use Illuminate\Contracts\Support\Arrayable;

class Tab implements Arrayable
{
    /**
     * The key of the tab.
     *
     * @var string
     */
    protected $key;

    /**
     * The label of the tab.
     *
     * @var string
     */
    protected $label;

    /**
     * The tab sections.
     *
     * @var array
     */
    protected $sections = [];

    /**
     * The title of the tab.
     *
     * @var string
     */
    protected $title;

    /**
     * Create a new tab.
     *
     * @param string $key
     * @param string $label
     * @param string|null $title
     */
    public function __construct($key, $label, $title = null)
    {
        $this->key = $key;
        $this->label = $this->title = $label;
        if (! is_null($title)) {
            $this->title = $title;
        }
    }

    public function addSection($key, $title, Closure $callable)
    {
        $section = new Section($key, $title);

        $callable($section);

        array_push($this->sections, $section);

        return $this;
    }

    public function toArray()
    {
        $sections = collect($this->sections)->map->toArray();

        return [
            'id' => $this->key,
            'label' => $this->label,
            'title' => $this->title,
            'sections' => $sections->all(),
        ];
    }
}
