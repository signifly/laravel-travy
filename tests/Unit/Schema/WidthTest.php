<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Signifly\Travy\Schema\Width;
use Signifly\Travy\Test\TestCase;

class WidthTest extends TestCase
{
    /** @test */
    public function it_sets_the_value()
    {
        $width = new Width(50);

        $this->assertEquals(50, $width->getValue());
    }

    /** @test */
    public function it_overwrites_on_creation()
    {
        $width = new Width(50);
        $this->assertEquals(50, $width->getOnCreation());

        $width->onCreation(80);

        $this->assertEquals(80, $width->getOnCreation());
    }

    /** @test */
    public function it_overwrites_on_index()
    {
        $width = new Width(50);
        $this->assertEquals(50, $width->getOnIndex());

        $width->onIndex(80);

        $this->assertEquals(80, $width->getOnIndex());
    }

    /** @test */
    public function it_overwrites_on_update()
    {
        $width = new Width(50);
        $this->assertEquals(50, $width->getOnUpdate());

        $width->onUpdate(80);

        $this->assertEquals(80, $width->getOnUpdate());
    }
}
