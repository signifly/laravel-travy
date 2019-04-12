<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Fields\Text;
use Signifly\Travy\Schema\Table;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Schema\Endpoint;

class TableTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $request = app(Request::class);
        $table = new class($request) extends Table {
            public function columns(): array
            {
                return [
                    Text::make('Title')
                        ->sortable(),
                ];
            }

            public function defaults(): array
            {
                return [
                    'sort' => [
                        'order' => 'ascending',
                        'prop' => 'title',
                    ],
                ];
            }

            public function endpoint(): Endpoint
            {
                return new Endpoint('some_url');
            }
        };

        tap($table->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'columns'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
            $this->assertEquals('title', Arr::get($data, 'defaults.sort.prop'));
        });
    }
}
