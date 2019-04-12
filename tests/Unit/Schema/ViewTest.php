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

class ViewTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $request = app(Request::class);
        $table = new class($request) extends View {
            public function tabs(): array
            {
                return [
                    Tab::make('Details')
                        ->type('table')
                        ->endpoint('some_url')
                        ->fields([
                            Text::make('Title')
                            ->sortable(),
                        ]),
                ];
            }

            public function header(): array
            {
                return [
                    'props' => [
                        'title' => 'title',
                        'image' => 'image_url',
                        'tag' => 'id',
                    ],
                ];
            }

            public function endpoint(): Endpoint
            {
                return new Endpoint('some_url');
            }

            public function sidebars(): array
            {
                return [
                    Sidebar::make('Title')
                        ->fields([
                            Text::make('Amount'),
                        ]),
                ];
            }
        };

        tap($table->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'tabs'));
            $this->assertCount(1, Arr::get($data, 'sidebars'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
            $this->assertEquals('title', Arr::get($data, 'header.props.title'));
        });
    }
}
