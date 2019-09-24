<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Date;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Sidebar;

class SidebarTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Sidebar::make('History')
            ->fields([
                Date::make('Created at'),
            ]);

        $expected = [
            'id' => 'history',
            'title' => 'History',
            'fields' => [
                [
                    'name' => 'Created at',
                    'attribute' => 'created_at',
                    'fieldType' => [
                        'id' => 'date',
                        'props' => [
                            'timestamp' => 'created_at',
                        ],
                    ],
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
