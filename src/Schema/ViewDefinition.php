<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Schema\Concerns\HasTabs;

abstract class ViewDefinition extends Definition
{
    use HasTabs;

    /**
     * Whether or not activity should be shown.
     *
     * @var bool
     */
    protected $activity;

    /**
     * Build the schema.
     *
     * @return array
     */
    public function build() : array
    {
        $this->schema();

        $schema = [
            'header' => ['fields' => $this->hasFields() ? $this->preparedFields() : (object) []],
            'endpoint' => $this->endpoint ?? $this->guessEndpoint(),
            'tabs' => $this->preparedTabs(),
        ];

        if ($this->hasActions()) {
            array_set($schema, 'actions', $this->preparedActions());
        }

        if ($this->hasIncludes()) {
            array_set($schema, 'includes', $this->includes);
        }

        if ($this->hasModifiers()) {
            array_set($schema, 'modifiers', $this->modifiers);
        }

        if ($this->hasSidebars()) {
            array_set($schema, 'sidebar.sections', $this->preparedSidebars());
        }

        if ($this->activity) {
            array_set($schema, 'activity', (object) []);
        }

        return $schema;
    }

    /**
     * Try guessing the endpoint.
     *
     * @return string|null
     */
    protected function guessEndpoint()
    {
        return [
            'url' => url("v1/admin/{$this->getResourceKey()}/{id}"),
            'method' => 'get',
        ];
    }

    /**
     * Show activity.
     *
     * @param  bool $value
     * @return self
     */
    protected function showsActivity($value = true)
    {
        $this->activity = $value;

        return $this;
    }
}
