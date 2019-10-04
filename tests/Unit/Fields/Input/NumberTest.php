<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Number;

class NumberTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Number::make('Number')
            ->disable()
            ->unit('cm');

        $expected = [
            'name' => 'Number',
            'attribute' => 'number',
            'fieldType' => [
                'id' => 'input-number',
                'props' => [
                    'value' => 'number',
                    '_unit' => 'cm',
                    '_disabled' => true,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = Number::make('Number')
            ->disable(false);

        $expected = [
            'name' => 'Number',
            'attribute' => 'number',
            'fieldType' => [
                'id' => 'input-number',
                'props' => [
                    'value' => 'number',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
