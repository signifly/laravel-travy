<?php

namespace Signifly\Travy\Test\Unit\Support;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Support\UnmappedProp;
use Signifly\Travy\Support\PropsResolver;

class PropsResolverTest extends TestCase
{
    protected $resolver;

    public function setUp(): void
    {
        parent::setUp();

        $this->resolver = new PropsResolver();
    }

    /** @test */
    public function it_resolves_mapped_props()
    {
        $props = [
            'this' => 'that',
            'list' => [
                ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                ['key_a' => 'value_ab', 'key_b' => 'value_bb'],
                ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
            ],
        ];

        $expected = $props;

        $this->assertSame($expected, $this->resolver->resolve($props));
    }

    /** @test */
    public function it_resolves_unmapped_props()
    {
        $props = [
            'this' => new UnmappedProp('that'),
            'list' => [
                ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                ['key_a' => 'value_ab', 'key_b' => new UnmappedProp('value_bb')],
                ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
            ],
        ];

        $expected = [
            '_this' => 'that',
            'list' => [
                ['key_a' => 'value_aa', 'key_b' => 'value_ba'],
                ['key_a' => 'value_ab', '_key_b' => 'value_bb'],
                ['key_a' => 'value_ac', 'key_b' => 'value_bc'],
            ],
        ];

        $this->assertSame($expected, $this->resolver->resolve($props));
    }
}
