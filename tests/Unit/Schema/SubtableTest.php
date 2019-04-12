<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Signifly\Travy\Fields\Text;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Schema\Subtable;

class SubtableTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $subtable = Subtable::make([
            Text::make('Name'),
        ])->endpoint('some_url');

        tap($subtable->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'columns'));
            $this->assertEquals('some_url', Arr::get($data, 'endpoint.url'));
        });
    }
}
