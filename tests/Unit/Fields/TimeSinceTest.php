<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\TimeSince;

class TimeSinceTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $date = TimeSince::make('Created at');

        $expected = [
            'name' => 'created_at',
            'label' => 'Created at',
            'fieldType' => [
                'id' => 'time-since',
                'props' => [
                    'timestamp' => 'created_at',
                ],
            ],
        ];
        $this->assertEquals($expected, $date->jsonSerialize());
    }
}
