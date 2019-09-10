<?php

namespace Signifly\Travy\Test\Unit\Fields;

use Signifly\Travy\Fields\Image;
use Signifly\Travy\Test\TestCase;

class ImageTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $field = Image::make('Image', 'src')
            ->size('100%', '300px');

        $expected = [
            'name' => 'src',
            'label' => 'Image',
            'fieldType' => [
                'id' => 'image',
                'props' => [
                    'src' => 'src',
                    'width' => '100%',
                    'height' => '300px',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }

    /** @test */
    public function it_can_set_the_fit_prop()
    {
        $field = Image::make('Image', 'src')
            ->size('100%', '300px')
            ->fit('contain');

        $expected = [
            'name' => 'src',
            'label' => 'Image',
            'fieldType' => [
                'id' => 'image',
                'props' => [
                    'src' => 'src',
                    'width' => '100%',
                    'height' => '300px',
                    'fit' => 'contain',
                ],
            ],
        ];
        $this->assertEquals($expected, $field->jsonSerialize());
    }
}
