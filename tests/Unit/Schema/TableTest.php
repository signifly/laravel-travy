<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Fields\Text;
use Signifly\Travy\Schema\Table;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Schema\Endpoint;
use Signifly\Travy\Concerns\WithDefaults;

class TableTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $request = app(Request::class);
        $table = new TestTable($request);

        tap($table->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'columns'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
        });
    }

    /** @test */
    public function it_can_serialize_with_defaults()
    {
        $request = app(Request::class);

        $table = new class($request) extends TestTable implements WithDefaults {
            public function defaults(): array
            {
                return [
                    'sort' => [
                        'order' => 'ascending',
                        'prop' => 'title',
                    ],
                ];
            }
        };

        tap($table->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'columns'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
            $this->assertEquals('title', data_get($data, 'defaults.sort.prop'));
        });
    }
}

class TestTable extends Table
{
    public function columns(): array
    {
        return [
            Text::make('Title')
                ->sortable(),
        ];
    }

    public function endpoint(): Endpoint
    {
        return new Endpoint('some_url');
    }
}
