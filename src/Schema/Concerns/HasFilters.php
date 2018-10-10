<?php

namespace Signifly\Travy\Schema\Concerns;

use Exception;
use Signifly\Travy\Schema\Filter;

trait HasFilters
{
    /**
     * The filters array.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * Add a new filter.
     *
     * @param string $name
     * @param string $label
     * @return \Signifly\Travy\Table\Filters\Filter
     */
    public function addFilter($name, $label)
    {
        $filter = new Filter($name, $label);

        array_push($this->filters, $filter);

        return $filter;
    }

    /**
     * Add filter from a callable definition.
     *
     * @param string $filter
     */
    public function addFilterFor(string $filter)
    {
        $class = new $filter;

        if (! is_callable($class)) {
            throw new Exception($filter . " must be callable.");
        }

        return $class($this);
    }

    /**
     * Determine if there are any filters.
     *
     * @return bool
     */
    public function hasFilters()
    {
        return count($this->filters) > 0;
    }

    /**
     * Get the prepared filters.
     *
     * @return array
     */
    protected function preparedFilters()
    {
        $filterFields = collect($this->filters)->map->toArray();
        $filterData = collect($this->filters)->flatMap->data();

        return [
            'fields' => $filterFields->all(),
            'data' => (object) $filterData->all(),
        ];
    }
}
