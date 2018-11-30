<?php

namespace Signifly\Travy\Schema;

use Illuminate\Support\Collection;

class ItemsCollection extends Collection
{
    /**
     * Convert to menu array.
     *
     * @return array
     */
    public function toMenu() : array
    {
        return $this->filter(function ($item) {
                return $item->asMenu;
            })
            ->values()
            ->map(function ($item) {
                return $item->toMenu();
            })
            ->toArray();
    }

    /**
     * Convert to table array.
     *
     * @return array
     */
    public function toTable() : array
    {
        $tables = collect();

        $this->each(function ($item) use ($tables) {
            if ($item->hasTable()) {
                $tables->push($item);
            }

            if ($item->hasItems()) {
                $item->items()->each(function ($item) use ($tables) {
                    if ($item->hasTable()) {
                        $tables->push($item);
                    }
                });
            }
        });

        return $tables->flatMap->toTable()->toArray();
    }
}
