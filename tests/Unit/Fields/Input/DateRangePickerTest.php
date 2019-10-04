<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\DateRangePicker;

class DateRangePickerTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = DateRangePicker::make('Special Date Range')
            ->clearable()
            ->disable()
            ->format('some format')
            ->formatValue('some format value')
            ->type('datetimerange');

        $expected = [
            'name' => 'Special Date Range',
            'attribute' => 'special_date_range',
            'fieldType' => [
                'id' => 'input-date-range',
                'props' => [
                    'dateStart' => 'special_date_range',
                    '_clearable' => true,
                    '_disabled' => true,
                    '_format' => 'some format',
                    '_formatValue' => 'some format value',
                    '_type' => 'datetimerange',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = DateRangePicker::make('Special Date Range')
            ->disable(false);

        $expected = [
            'name' => 'Special Date Range',
            'attribute' => 'special_date_range',
            'fieldType' => [
                'id' => 'input-date-range',
                'props' => [
                    'dateStart' => 'special_date_range',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
