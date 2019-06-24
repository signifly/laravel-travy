<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Input\Image;

class ImageTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Image::make('Image', 'image_upload')
            ->upload(false)
            ->url('image_url')
            ->size('80px', '80px');

        $expected = [
            'name' => 'image_upload',
            'label' => 'Image',
            'fieldType' => [
                'id' => 'input-image',
                'props' => [
                    'file' => 'image_upload',
                    'upload' => false,
                    'url' => 'image_url',
                    'width' => '80px',
                    'height' => '80px',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
