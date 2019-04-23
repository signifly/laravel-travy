<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Text;
use Signifly\Travy\Test\TestCase;

class TextTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Text::make('Name');

        $expected = [
            'name' => 'name',
            'label' => 'Name',
            'fieldType' => [
                'id' => 'text',
                'props' => [
                    'text' => 'name',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_converted_to_an_input()
    {
        $field = Text::make('Name')->asInput();

        $expected = [
            'name' => 'name',
            'label' => 'Name',
            'fieldType' => [
                'id' => 'input-text',
                'props' => [
                    'value' => 'name',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_allows_setting_an_input_type()
    {
        $field = Text::make('Email')
            ->asInput()
            ->type('email');

        $expected = [
            'name' => 'email',
            'label' => 'Email',
            'fieldType' => [
                'id' => 'input-text',
                'props' => [
                    'value' => 'email',
                    'type' => 'email',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_allows_setting_a_unit_prop()
    {
        $field = Text::make('Height')
            ->asInput()
            ->unit('cm');

        $expected = [
            'name' => 'height',
            'label' => 'Height',
            'fieldType' => [
                'id' => 'input-text',
                'props' => [
                    'value' => 'height',
                    'unit' => 'cm',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
