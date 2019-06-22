<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\ReorderMini;

class ReorderMiniTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = ReorderMini::make('Variants', 'ids')
            ->columns([
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name', 'label' => 'Name'],
            ])
            ->endpoint('some_url')
            ->key('data')
            ->value('id');

        $expected = [
            'name' => 'ids',
            'label' => 'Variants',
            'fieldType' => [
                'id' => 'input-reorder-mini',
                'props' => [
                    'prop' => 'ids',
                    'columns' => [
                        ['key' => 'id', 'label' => 'ID'],
                        ['key' => 'name', 'label' => 'Name'],
                    ],
                    'options' => [
                        'key' => 'data',
                        'value' => 'id',
                        'endpoint' => [
                            'url' => 'some_url',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
