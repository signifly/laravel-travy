<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\RadioGroup;
use Signifly\Travy\Exceptions\InvalidPropsException;

class RadioGroupTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = RadioGroup::make('Radio Group')
            ->items([
                [
                    'label' => 'Option A',
                    'value' => true,
                ],
                [
                    'label' => 'Option B',
                    'value' => false,
                ],
                [
                    'label' => 'Option C',
                    'value' => 3,
                ],
                [
                    'label' => 'Option D',
                    'value' => 4,
                    'disabled' => true,
                ],
            ]);

        $expected = [
            'name' => 'Radio Group',
            'attribute' => 'radio_group',
            'fieldType' => [
                'id' => 'input-radio-group',
                'props' => [
                    'value' => 'radio_group',
                    '_items' => [
                        [
                            'label' => 'Option A',
                            'value' => true,
                        ],
                        [
                            'label' => 'Option B',
                            'value' => false,
                        ],
                        [
                            'label' => 'Option C',
                            'value' => 3,
                        ],
                        [
                            'label' => 'Option D',
                            'value' => 4,
                            'disabled' => true,
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_throws_if_items_havent_been_set()
    {
        $this->expectException(InvalidPropsException::class);

        $field = RadioGroup::make('Radio Group');

        $field->jsonSerialize();
    }
}
