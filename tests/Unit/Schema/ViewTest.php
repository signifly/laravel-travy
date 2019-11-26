<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Fields\Tab;
use Signifly\Travy\Fields\Text;
use Signifly\Travy\Schema\View;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Sidebar;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Fields\Input\Select;
use Signifly\Travy\Concerns\WithModifiers;

class ViewTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $request = app(Request::class);
        $view = new ShopView($request);

        tap($view->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'tabs'));
            // $this->assertCount(1, Arr::get($data, 'sidebar'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
            $this->assertEquals('Shop {name}', Arr::get($data, 'pageTitle'));
        });
    }

    /** @test */
    public function it_serialies_with_modifiers()
    {
        $request = app(Request::class);
        $view = new ModifierShopView($request);

        tap($view->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'tabs'));
            $this->assertCount(1, Arr::get($data, 'modifiers.fields'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
            $this->assertEquals('Shop {name}', Arr::get($data, 'pageTitle'));
        });
    }
}

class ShopView extends View
{
    public function pageTitle(): string
    {
        return 'Shop {name}';
    }

    public function hero(): array
    {
        return [
            'title' => '{name}',
            'subtitle' => 'Lorem ipsum bla bla bla bla',
        ];
    }

    public function tabs(): array
    {
        return [
            Tab::make('Details')
                ->type('table')
                ->endpoint('some_url')
                ->fields([
                    Text::make('Name'),
                ]),
        ];
    }

    public function endpoint(): Endpoint
    {
        return new Endpoint('some_url');
    }
}

class ModifierShopView extends ShopView implements WithModifiers
{
    public function modifiers(): array
    {
        return [
            Select::make('Shop')
                ->items([
                    ['label' => 'Test', 'value' => 'test'],
                    ['label' => 'Test 2', 'value' => 'test-2'],
                ]),
        ];
    }
}
