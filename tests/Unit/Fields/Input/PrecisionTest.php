<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Precision;

class PrecisionTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Precision::make('Precision')
            ->disable()
            ->max(10)
            ->precision(2)
            ->step(0.1);

        $expected = [
            'name' => 'Precision',
            'attribute' => 'precision',
            'fieldType' => [
                'id' => 'input-precision',
                'props' => [
                    'value' => 'precision',
                    '_disabled' => true,
                    '_max' => 10,
                    '_precision' => 2,
                    '_step' => 0.1,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = Precision::make('Precision')
            ->disable(false);

        $expected = [
            'name' => 'Precision',
            'attribute' => 'precision',
            'fieldType' => [
                'id' => 'input-precision',
                'props' => [
                    'value' => 'precision',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
