<?php

namespace Signifly\Travy\Schema;

use Illuminate\Http\Request;
use Signifly\Travy\Contracts\Table as Contract;

abstract class Table extends Definition implements Contract
{
    /** @var \Illuminate\Http\Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function preparedActions(): array
    {
        return collect($this->actions())
            ->map->jsonSerialize()
            ->toArray();
    }

    public function preparedColumns(): array
    {
        return collect($this->columns())
            ->mapInto(Column::class)
            ->map(function ($column, $index) {
                return $column->setWidth()
                    ->order($index + 1)
                    ->jsonSerialize();
            })
            ->toArray();
    }

    public function toSchema(): Schema
    {
        $schema = new Schema([
            'columns' => $this->preparedColumns(),
            'endpoint' => $this->endpoint(),
        ]);

        $this->applyConcerns($schema);

        // Allow doing some final configurations
        if (method_exists($this, 'prepareSchema')) {
            $this->prepareSchema($schema);
        }

        return $schema;
    }

    public function toArray()
    {
        return $this->toSchema()->toArray();
    }

    protected function applyConcerns(Schema $schema): void
    {
        foreach (class_implements($this) as $interface) {
            $method = 'apply'.class_basename($interface);

            if (method_exists($this, $method)) {
                $this->$method($schema);
            }
        }
    }

    protected function applyWithActions(Schema $schema): void
    {
        $schema->set('actions', $this->preparedActions());
    }

    protected function applyWithBatchActions(Schema $schema): void
    {
        $schema->set('batch', $this->batch()->jsonSerialize());
    }

    protected function applyWithChannel(Schema $schema): void
    {
        $schema->set('ws.channel', $this->channel());
    }

    protected function applyWithDefaults(Schema $schema): void
    {
        $schema->set('defaults', $this->defaults());
    }

    protected function applyWithExpand(Schema $schema): void
    {
        $schema->set('expand', $this->expand()->jsonSerialize());
    }

    protected function applyWithFilters(Schema $schema): void
    {
        $schema->set('filters', $this->filters());
    }

    protected function applyWithPagination(Schema $schema): void
    {
        $schema->set('pagination', (object) []);
    }

    protected function applyWithSearch(Schema $schema): void
    {
        $schema->set('search.placeholder', $this->searchPlaceholder());
    }
}
