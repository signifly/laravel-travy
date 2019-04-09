<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Collection;

class ItemsCollection extends Collection
{
    /**
     * Convert to dashboard array.
     *
     * @return array
     */
    public function toDashboard(): array
    {
        return $this->filter->asDashboard
            ->values()
            ->flatMap->toDashboard()
            ->toArray();
    }

    /**
     * Convert to menu array.
     *
     * @return array
     */
    public function toMenu(): array
    {
        return $this->filter->asMenu
            ->values()
            ->map->toMenu()
            ->toArray();
    }

    /**
     * Convert to table array.
     *
     * @return array
     */
    public function toTable(): array
    {
        $tables = collect();

        $this->each(function ($item) use ($tables) {
            if ($item->hasTable()) {
                $tables->push($item);
            }

            if (! $item->hasItems()) {
                return;
            }

            $item->items()->filter->hasTable()
                ->each(function ($item) use ($tables) {
                    $tables->push($item);
                });
        });

        return $tables->flatMap->toTable()->toArray();
    }
}
