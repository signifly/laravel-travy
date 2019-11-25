<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Concerns\WithDefaults;
use Signifly\Travy\Test\Support\Table\TestTable;

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
