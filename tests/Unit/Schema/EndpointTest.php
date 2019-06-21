<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Schema\Endpoint;

class EndpointTest extends TestCase
{
    /** @test */
    public function it_converts_to_an_array()
    {
        $endpoint = new Endpoint('some_url');

        $expected = ['url' => 'some_url'];
        $this->assertEquals($expected, $endpoint->toArray());
    }

    /** @test */
    public function it_can_add_a_param()
    {
        $endpoint = new Endpoint('some_url');

        $endpoint->addParam('test', 'test');

        $expected = [
            'url' => 'some_url',
            'params' => [
                'test' => 'test'
            ],
        ];
        $this->assertEquals($expected, $endpoint->toArray());
    }

    /** @test */
    public function it_can_add_a_filter_param()
    {
        $endpoint = new Endpoint('some_url');

        $endpoint->addFilter('test', 'test');

        $expected = [
            'url' => 'some_url',
            'params' => [
                'filter' => ['test' => 'test'],
            ],
        ];
        $this->assertEquals($expected, $endpoint->toArray());
    }

    /** @test */
    public function it_can_add_a_sort_param()
    {
        $endpoint = new Endpoint('some_url');

        $endpoint->addSort('test');

        $expected = [
            'url' => 'some_url',
            'params' => [
                'sort' => 'test',
            ],
        ];
        $this->assertEquals($expected, $endpoint->toArray());
    }

    /** @test */
    public function it_can_specify_the_method()
    {
        $endpoint = new Endpoint('some_url');

        $endpoint->usingMethod('post');

        $expected = [
            'url' => 'some_url',
            'method' => 'post',
        ];
        $this->assertEquals($expected, $endpoint->toArray());
    }

    /** @test */
    public function it_can_set_the_payload()
    {
        $endpoint = new Endpoint('some_url');

        $endpoint->payload(['data' => ['key' => 'value']]);

        $expected = [
            'url' => 'some_url',
            'payload' => [
                'data' => ['key' => 'value'],
            ],
        ];
        $this->assertEquals($expected, $endpoint->toArray());
    }
}
