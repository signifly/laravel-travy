<?php

namespace Signifly\Travy\Test;

use Signifly\Travy\TravyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Waavi\Sanitizer\Laravel\SanitizerServiceProvider;

abstract class TestCase extends Orchestra
{
    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:9e0yNQB60wgU/cqbP09uphPo3aglW3iQJy+u4JQgnQE=');
        $app['config']->set('travy.definitions.namespace', 'Signifly\\Travy\\Test\\Support');
    }

    protected function getPackageProviders($app)
    {
        return [
            SanitizerServiceProvider::class,
            TravyServiceProvider::class,
        ];
    }
}
