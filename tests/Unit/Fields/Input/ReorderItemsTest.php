<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\ReorderItems;

class ReorderItemsTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = ReorderItems::make('Variants')
            ->image('image_url')
            ->list([
                ['label' => 'SKU', 'value' => 'sku'],
                ['label' => 'Items', 'value' => 'items_count'],
            ])
            ->endpoint('some_url', function ($endpoint) {
                $endpoint->usingMethod('post')
                    ->payload(['type' => 'ReorderVariants']);
            });

        $expected = [
            'name' => 'variants',
            'label' => 'Variants',
            'fieldType' => [
                'id' => 'input-reorder-items',
                'props' => [
                    'items' => [
                        'data' => 'variants',
                        'image' => 'image_url',
                        'list' => [
                            ['label' => 'SKU', 'value' => 'sku'],
                            ['label' => 'Items', 'value' => 'items_count'],
                        ],
                        'actions' => [],
                    ],
                    'endpoint' => [
                        'url' => 'some_url',
                        'method' => 'post',
                        'payload' => [
                            'type' => 'ReorderVariants',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}