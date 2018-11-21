<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Fields\Tab;
use Signifly\Travy\Fields\Sidebar;
use Signifly\Travy\Schema\Concerns\HasTabs;
use Spatie\Activitylog\Traits\LogsActivity;
use Signifly\Travy\Schema\Concerns\HasSidebars;

abstract class ViewDefinition extends Definition
{
    use HasTabs;
    use HasSidebars;

    /**
     * Whether or not activity should be shown.
     *
     * @var bool
     */
    protected $activity;

    /**
     * The header tag attribute.
     *
     * @var string
     */
    protected $headerTag = 'id';

    /**
     * Build the schema.
     *
     * @return array
     */
    public function build() : array
    {
        $this->schema();

        $schema = [
            'header' => [
                'props' => [
                    'title' => $this->headerTitleFromResource(),
                    'image' => $this->headerImageFromResource(),
                    'tag' => $this->headerTag,
                ],
            ],
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
            array_set($schema, 'sidebar', $this->preparedSidebars());
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
     * Get the header image from the resource.
     *
     * @return string
     */
    protected function headerImageFromResource()
    {
        $fields = $this->request->resource()->getPreparedFields();

        $field = $fields->first(function ($field) {
            return $field->isHeaderImage;
        });

        return $field ? $field->attribute : '';
    }

    /**
     * Get the header title from the resource.
     *
     * @return string
     */
    protected function headerTitleFromResource()
    {
        $fields = $this->request->resource()->getPreparedFields();

        $field = $fields->first(function ($field) {
            return $field->isHeaderTitle;
        });

        return $field ? $field->attribute : '';
    }

    protected function loadFromResource()
    {
        $fields = collect($this->request->resource()->fields());

        // Add tabs from resource
        $fields->each(function ($field) {
            if (! $field instanceof Tab || ! $field->showOnUpdate) {
                return;
            }

            if (! $field->hasEndpoint()) {
                $field->endpoint(url("v1/admin/{$this->getResourceKey()}/{id}"));
            }

            // Filter fields
            $field->fields = collect($field->fields)
                ->filter(function ($field) {
                    return $field->showOnUpdate;
                })
                ->map(function ($field) {
                    if ($field->component == 'text') {
                        $field->asInput();
                    }

                    return $field;
                })
                ->values()
                ->toArray();

            $this->addTab($field);
        });

        // Add sections from resource
        $fields->each(function ($field) {
            if (! $field instanceof Sidebar) {
                return;
            }

            $this->addSidebar($field);
        });

        // Check activity
        $modelTraits = collect(class_uses_recursive($this->request->resource()->getModel()));

        if ($modelTraits->contains(LogsActivity::class)) {
            $this->showsActivity();
        }
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
