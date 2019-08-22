<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Signifly\Travy\Schema\Batch;
use Signifly\Travy\Schema\Popup;
use Signifly\Travy\Test\TestCase;

class BatchTest extends TestCase
{
    /** @test */
    public function it_enables_sequential_edit()
    {
        $batch = Batch::make('name', '/t/products/{id}');

        $expected = [
            'selectedOptions' => [
                'label' => 'name',
                'link' => '/t/products/{id}',
            ],
            'sequential' => [
                'url' => '/t/products/{id}',
            ],
        ];
        $this->assertEquals($expected, $batch->jsonSerialize());
    }

    /** @test */
    public function it_has_bulk_actions()
    {
        $batch = Batch::make('name', '/t/products/{id}')
            ->actions([
                Popup::make('Delete selected items')
                    ->endpoint(url('v1/admin/products/{id}')),
            ]);

        $expected = [
            'bulk' => [
                'actions' => [
                    [
                        'title' => 'Delete selected items',
                        'props' => [
                            'title' => 'Delete selected items',
                            'id' => 'popup',
                            'text' => 'Are you sure? Please confirm this action.',
                            'endpoint' => [
                                'url' => 'http://localhost/v1/admin/products/{id}',
                                'method' => 'post',
                            ],
                        ],
                    ],
                ],
            ],
            'selectedOptions' => [
                'label' => 'name',
                'link' => '/t/products/{id}',
            ],
            'sequential' => [
                'url' => '/t/products/{id}',
            ],
        ];
        $this->assertEquals($expected, $batch->jsonSerialize());
    }
}
