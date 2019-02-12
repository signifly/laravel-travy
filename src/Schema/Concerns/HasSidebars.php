<?php

namespace Signifly\Travy\Schema\Concerns;

use Exception;
use Signifly\Travy\Schema\Section;

trait HasSidebars
{
    /**
     * The sidebar sections for the definition schema.
     *
     * @var array
     */
    protected $sidebars = [];

    /**
     * Add a new sidebar.
     *
     * @param string $key
     * @param string $title
     *
     * @return \Signifly\Travy\Section
     */
    public function addSidebar($key, $title)
    {
        $section = new Section($key, $title);

        array_push($this->sidebars, $section);

        return $section;
    }

    /**
     * Add sidebar for callable definition.
     *
     * @param string $sidebar
     */
    public function addSidebarFor(string $sidebar)
    {
        $class = new $sidebar();

        if (!is_callable($class)) {
            throw new Exception($sidebar.' must be callable.');
        }

        return $class($this);
    }

    /**
     * Determines if there are any sidebars.
     *
     * @return bool
     */
    public function hasSidebars()
    {
        return count($this->sidebars) > 0;
    }

    /**
     * Prepare the sidebars.
     *
     * @return array
     */
    protected function preparedSidebars()
    {
        return collect($this->sidebars)->map->toArray();
    }
}
