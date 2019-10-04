<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\DatePicker;

class DatePickerTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = DatePicker::make('Special Date')
            ->clearable()
            ->disable()
            ->format('some format')
            ->formatValue('some format value')
            ->type('datetime');

        $expected = [
            'name' => 'Special Date',
            'attribute' => 'special_date',
            'fieldType' => [
                'id' => 'input-date',
                'props' => [
                    'date' => 'special_date',
                    '_clearable' => true,
                    '_disabled' => true,
                    '_format' => 'some format',
                    '_formatValue' => 'some format value',
                    '_type' => 'datetime',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = DatePicker::make('Special Date')
            ->disable(false);

        $expected = [
            'name' => 'Special Date',
            'attribute' => 'special_date',
            'fieldType' => [
                'id' => 'input-date',
                'props' => [
                    'date' => 'special_date',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
