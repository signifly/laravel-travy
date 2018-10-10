<?php

namespace Signifly\Travy\Schema\Concerns;

use Signifly\Travy\Schema\Tab;

trait HasTabs
{
    /**
     * The tabs for the definition schema.
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * Add modifier to the definition schema.
     *
     * @param string $key
     * @param string $label
     * @param string|null $title
     * @return \Signifly\Travy\Tab
     */
    public function addTab($key, $label, $title = null)
    {
        $tab = new Tab($key, $label, $title);

        array_push($this->tabs, $tab);

        return $tab;
    }

    /**
     * Determines if there are any tabs.
     *
     * @return bool
     */
    public function hasTabs()
    {
        return count($this->tabs) > 0;
    }

    /**
     * Prepare the tabs.
     *
     * @return array
     */
    protected function preparedTabs()
    {
        return collect($this->tabs)->map->toArray();
    }
}
