<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Support\DashboardFactory;
use Signifly\Travy\Test\Support\Dashboard\DefaultDashboard;

class DashboardFactoryTest extends TestCase
{
    /** @test */
    public function it_creates_a_dashboard()
    {
        $dashboard = DashboardFactory::make('default');

        $this->assertInstanceOf(DefaultDashboard::class, $dashboard);
    }
}
