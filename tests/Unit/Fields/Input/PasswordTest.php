<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Password;

class PasswordTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Password::make('Password')
            ->disable();

        $expected = [
            'name' => 'Password',
            'attribute' => 'password',
            'fieldType' => [
                'id' => 'input-password',
                'props' => [
                    'value' => 'password',
                    '_disabled' => true,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = Password::make('Password')
            ->disable(false);

        $expected = [
            'name' => 'Password',
            'attribute' => 'password',
            'fieldType' => [
                'id' => 'input-password',
                'props' => [
                    'value' => 'password',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
