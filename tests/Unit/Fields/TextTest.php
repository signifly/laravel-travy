<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Text;
use Signifly\Travy\Test\TestCase;

class TextTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $date = Text::make('Name');

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
        $this->assertEquals($expected, $date->jsonSerialize());
    }

    /** @test */
    public function it_can_be_converted_to_an_input()
    {
        $date = Text::make('Name')->asInput();

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
        $this->assertEquals($expected, $date->jsonSerialize());
    }

    /** @test */
    public function it_allows_setting_an_input_type()
    {
        $date = Text::make('Email')
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
        $this->assertEquals($expected, $date->jsonSerialize());
    }

    /** @test */
    public function it_allows_setting_a_unit_prop()
    {
        $date = Text::make('Height')
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
        $this->assertEquals($expected, $date->jsonSerialize());
    }
}
