<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Progress;

class ProgressTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Progress::make('Status')
            ->color('danger');

        $expected = [
            'name' => 'status',
            'label' => 'Status',
            'fieldType' => [
                'id' => 'progress',
                'props' => [
                    'percentage' => 'status',
                    'status' => 'danger',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
