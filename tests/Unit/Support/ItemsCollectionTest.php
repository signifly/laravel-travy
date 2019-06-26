<?php

namespace Signifly\Travy\Test\Unit\Support;

use Signifly\Travy\Schema\Item;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Schema\ItemsCollection;

class ItemsCollectionTest extends TestCase
{
    /** @test */
    public function it_creates_a_menu()
    {
        $items = ItemsCollection::make([
            Item::make('Home')
                ->link('/t/home'),

            Item::make('Products')
                ->asTable(),

            Item::make('Default')
                ->asDashboard(),
        ]);

        $this->assertCount(2, $items->toMenu());
        $this->assertCount(1, $items->toTable());
        $this->assertCount(1, $items->toDashboard());
    }
}
