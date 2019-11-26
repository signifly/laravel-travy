<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Date;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Support\UnmappedProp;

class DateTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $date = Date::make('Created at');

        $expected = [
            'name' => 'Created at',
            'attribute' => 'created_at',
            'fieldType' => [
                'id' => 'date',
                'props' => [
                    'timestamp' => 'created_at',
                ],
            ],
        ];
        $this->assertEquals($expected, $date->jsonSerialize());
    }

    /** @test */
    public function it_serializes_unmapped_timestamp_to_json()
    {
        $time = time();
        $date = Date::make('Created at', new UnmappedProp($time));

        $expected = [
            'name' => 'Created at',
            'attribute' => 'created_at',
            'fieldType' => [
                'id' => 'date',
                'props' => [
                    '_timestamp' => $time,
                ],
            ],
        ];
        $this->assertEquals($expected, $date->jsonSerialize());
    }

    /** @test */
    public function it_allows_to_set_width()
    {
        $date = Date::make('Created at')
            ->width(50);

        $this->assertEquals(50, $date->getMeta('width'));
    }
}
