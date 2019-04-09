<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Date;
use Signifly\Travy\Test\TestCase;

class DateTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $date = Date::make('Created at');

        $expected = [
            'name' => 'created_at',
            'label' => 'Created at',
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
    public function it_allows_to_set_width()
    {
        $date = Date::make('Created at')->width(50);

        $this->assertEquals(50, $date->width->getValue());
    }
}
