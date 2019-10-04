<?php

namespace Signifly\Travy\Test\Unit\Fields\Input;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Editor;

class EditorTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Editor::make('Rich Text Field')
            ->disable();

        $expected = [
            'name' => 'Rich Text Field',
            'attribute' => 'rich_text_field',
            'fieldType' => [
                'id' => 'input-editor-markdown',
                'props' => [
                    'content' => 'rich_text_field',
                    '_disabled' => true,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_be_explicitly_enabled()
    {
        $field = Editor::make('Rich Text Field')
            ->disable(false);

        $expected = [
            'name' => 'Rich Text Field',
            'attribute' => 'rich_text_field',
            'fieldType' => [
                'id' => 'input-editor-markdown',
                'props' => [
                    'content' => 'rich_text_field',
                    '_disabled' => false,
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
