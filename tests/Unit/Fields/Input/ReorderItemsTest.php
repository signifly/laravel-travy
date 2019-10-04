<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\ReorderItems;
use Signifly\Travy\Exceptions\InvalidPropsException;

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
            'name' => 'Variants',
            'attribute' => 'variants',
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
                    '_endpoint' => [
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

    /** @test */
    public function it_throws_if_endpoint_hasnt_been_set()
    {
        $this->expectException(InvalidPropsException::class);

        $field = ReorderItems::make('Variants')
            ->image('image_url');

        $field->jsonSerialize();
    }

    /** @test */
    public function it_throws_if_list_is_missing()
    {
        $this->expectException(InvalidPropsException::class);

        $field = ReorderItems::make('Variants')
            ->endpoint('some_url', function ($endpoint) {
                $endpoint->usingMethod('post')
                    ->payload(['type' => 'ReorderVariants']);
            });

        $field->jsonSerialize();
    }

    /** @test */
    public function it_throws_if_list_element_label_is_missing()
    {
        $this->expectException(InvalidPropsException::class);

        $field = ReorderItems::make('Variants')
            ->list([
                ['label' => 'SKU', 'value' => 'sku'],
                ['NO_LABEL' => 'Items', 'value' => 'items_count'],
            ])
            ->endpoint('some_url', function ($endpoint) {
                $endpoint->usingMethod('post')
                    ->payload(['type' => 'ReorderVariants']);
            });

        $field->jsonSerialize();
    }

    /**
     * @test
     * @dataProvider provideInvalidListLabelValues
     */
    public function it_throws_if_list_element_label_value_is_not_valid($invalidLabelValue)
    {
        $this->expectException(InvalidPropsException::class);

        $field = ReorderItems::make('Variants')
            ->list([
                ['label' => 'SKU', 'value' => 'sku'],
                ['label' => $invalidLabelValue, 'value' => 'items_count'],
            ])
            ->endpoint('some_url', function ($endpoint) {
                $endpoint->usingMethod('post')
                    ->payload(['type' => 'ReorderVariants']);
            });

        $field->jsonSerialize();
    }

    public function provideInvalidListLabelValues(): array
    {
        return [
            [null],
            [true],
            [false],
            [['array', 'of', 'strings']],
            [1234],
            [1.234],
            [function () { return 'any value'; }],
            [new \stdClass()],
        ];
    }

    /** @test */
    public function it_throws_if_list_element_value_is_missing()
    {
        $this->expectException(InvalidPropsException::class);

        $field = ReorderItems::make('Variants')
            ->list([
                ['label' => 'SKU', 'value' => 'sku'],
                ['label' => 'Items', 'NO_VALUE' => 'items_count'],
            ])
            ->endpoint('some_url', function ($endpoint) {
                $endpoint->usingMethod('post')
                    ->payload(['type' => 'ReorderVariants']);
            });

        $field->jsonSerialize();
    }
}
