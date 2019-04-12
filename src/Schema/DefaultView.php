<?php

namespace Signifly\Travy\Schema;

use Signifly\Travy\Fields\Tab;
use Signifly\Travy\Fields\Actions;
use Signifly\Travy\Fields\Sidebar;
use Signifly\Travy\Support\FieldCollection;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Signifly\Travy\Http\Requests\TravyRequest;

class DefaultView extends View
{
    /** @var \Signifly\Travy\Http\Requests\TravyRequest */
    protected $request;

    /** @var \Signifly\Travy\Resource */
    protected $resource;

    /** @var string */
    protected $headerTag = 'id';

    public function __construct(TravyRequest $request)
    {
        $this->request = $request;
        $this->resource = $request->resource();
    }

    public function actions(): array
    {
        return [
            Popup::make('Delete', 'danger')
                ->icon('delete')
                ->endpoint(
                    url("v1/admin/{$this->request->resourceKey()}/{id}"),
                    function ($endpoint) {
                        $endpoint->usingMethod('delete');
                    }
                )
                ->onSubmit("/t/{$this->request->resourceKey()}"),
        ];
    }

    public function endpoint(): Endpoint
    {
        $url = url("v1/admin/{$this->request->resourceKey()}/{id}");

        return new Endpoint($url);
    }

    public function header(): array
    {
        $fields = $this->resource->getPreparedFields();

        $headerTitle = $fields->first->isHeaderTitle;
        $headerImage = $fields->first->isHeaderImage;

        return [
            'props' => [
                'title' => $headerTitle ? $headerTitle->attribute : null,
                'image' => $headerImage ? $headerImage->attribute : null,
                'tag' => $this->headerTag,
            ]
        ];
    }

    public function modifiers(): array
    {
        $fields = new FieldCollection($this->resource->modifiers());

        if ($fields->isEmpty()) {
            return [];
        }

        return [
            'data' => $fields->toData(),
            'fields' => $fields->prepared(),
        ];
    }

    public function sidebars(): array
    {
        return collect($this->resource->fields())
            ->filter(function ($field) {
                return $field instanceof Sidebar;
            })
            ->map(function ($field) {
                $field->fields = $this->prepareFieldsFor($field);

                return $field;
            })
            ->values()
            ->toArray();
    }

    public function tabs(): array
    {
        return collect($this->resource->fields())
            ->filter(function ($field) {
                return $field instanceof Tab && $field->showOnUpdate;
            })
            ->map(function ($tab) {
                if (! $tab->hasEndpoint()) {
                    $tab->endpoint(url("v1/admin/{$this->request->resourceKey()}/{id}"));
                }

                $tab->fields = $this->prepareFieldsFor($tab);

                return $tab;
            })
            ->values()
            ->toArray();
    }

    protected function prepareFieldsFor($fieldElement): array
    {
        return collect($fieldElement->fields)
            ->filter(function ($field) {
                return $field->showOnUpdate;
            })
            ->map(function ($field) use ($fieldElement) {
                if ($fieldElement instanceof Tab && $field->component == 'text') {
                    $field->asInput();
                }

                // Set width
                if ($field->width instanceof Width) {
                    $field->withMeta(['width' => $field->width->getOnUpdate()]);
                }

                return $field;
            })
            ->values()
            ->toArray();
    }

    public function toArray()
    {
        // Check activity
        $modelTraits = collect(class_uses_recursive($this->resource->modelClass()));

        if (
            $modelTraits->contains(LogsActivity::class) ||
            $modelTraits->contains(CausesActivity::class)
        ) {
            $this->activity = true;
        }

        return parent::toArray();
    }
}
