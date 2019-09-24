<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\KeyValueBox;

class KeyValueBoxTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = KeyValueBox::make('Some title')
            ->addItem('Name', 'name')
            ->addItem('Items', 'items_count');

        $expected = [
            'name' => 'Some title',
            'attribute' => 'some_title',
            'fieldType' => [
                'id' => 'key-value-box',
                'props' => [
                    'items' => [
                        ['label' => 'Name', 'value' => 'name'],
                        ['label' => 'Items', 'value' => 'items_count'],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
