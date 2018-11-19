<?php

namespace Signifly\Travy\Schema\Concerns;

use Signifly\Travy\Fields\Sidebar;

trait HasSidebars
{
    /**
     * The sidebars for the definition schema.
     *
     * @var array
     */
    protected $sidebars = [];

    /**
     * Add modifier to the definition schema.
     *
     * @param \Signifly\Travy\Sidebar $sidebar
     * @return \Signifly\Travy\Sidebar
     */
    public function addSidebar(Sidebar $sidebar)
    {
        array_push($this->sidebars, $sidebar);

        return $sidebar;
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
        return collect($this->sidebars)
            ->map(function ($sidebar) {
                return $sidebar->jsonSerialize();
            })
            ->toArray();
    }
}
