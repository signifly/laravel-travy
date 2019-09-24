<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\ColorPicker;

class ColorPickerTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = ColorPicker::make('Color Code');

        $expected = [
            'name' => 'Color Code',
            'attribute' => 'color_code',
            'fieldType' => [
                'id' => 'input-color-picker',
                'props' => [
                    'value' => 'color_code',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
