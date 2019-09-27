<?php

namespace Signifly\Travy\Test\Unit\Support;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Support\ScopesApplier;

class ScopesApplierTest extends TestCase
{
    protected $applier;

    public function setUp(): void
    {
        parent::setUp();

        $this->applier = new ScopesApplier();
    }

    /** @test */
    public function it_applies_a_simple_scope()
    {
        $scopes = [
            'items' => 'people',
        ];

        $props = [
            'items' => [
                'this' => 'that',
                'list' => [
                    ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                    ['key_a' => 'value_ab', 'key_b' => 'value_bb'],
                    ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
                ],
                'something_with_items' => [
                    'items' => [
                        'key_a' => 'value_a',
                        'key_b' => 'value_b',
                    ],
                ],
            ],
        ];

        $expected = [
            'items' => [
                '@scope' => 'people',
                'this' => 'that',
                'list' => [
                    ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                    ['key_a' => 'value_ab', 'key_b' => 'value_bb'],
                    ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
                ],
                'something_with_items' => [
                    'items' => [
                        'key_a' => 'value_a',
                        'key_b' => 'value_b',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $this->applier->apply($props, $scopes));
    }

    /** @test */
    public function it_applies_a_scope_array_with_a_deep_scope()
    {
        $scopes = [
            'items' => 'people',
            'items.something_with_items.items' => 'deep',
        ];

        $props = [
            'items' => [
                'this' => 'that',
                'list' => [
                    ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                    ['key_a' => 'value_ab', 'key_b' => 'value_bb'],
                    ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
                ],
                'something_with_items' => [
                    'items' => [
                        'key_a' => 'value_a',
                        'key_b' => 'value_b',
                    ],
                ],
            ],
        ];

        $expected = [
            'items' => [
                '@scope' => 'people',
                'this' => 'that',
                'list' => [
                    ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                    ['key_a' => 'value_ab', 'key_b' => 'value_bb'],
                    ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
                ],
                'something_with_items' => [
                    'items' => [
                        '@scope' => 'deep',
                        'key_a' => 'value_a',
                        'key_b' => 'value_b',
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $this->applier->apply($props, $scopes));
    }
}
