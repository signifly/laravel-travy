<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Checkbox;

class CheckboxTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Checkbox::make('Accept Terms');

        $expected = [
            'name' => 'Accept Terms',
            'attribute' => 'accept_terms',
            'fieldType' => [
                'id' => 'input-checkbox',
                'props' => [
                    'value' => 'accept_terms',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
