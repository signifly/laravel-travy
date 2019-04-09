<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Fields\Section;
use Signifly\Travy\Schema\Dashboard;

class DashboardTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        $dashboard = new class extends Dashboard {
            public function sections(): array
            {
                return [
                    Section::make('Default')
                        ->type('table')
                        ->endpoint('some_url'),
                ];
            }
        };

        tap($dashboard->jsonSerialize(), function ($data) {
            $this->assertCount(1, Arr::get($data, 'sections'));
            $this->assertEquals('Default', Arr::get($data, 'sections.0.title.text'));
            $this->assertEquals('table', Arr::get($data, 'sections.0.type'));
            $this->assertEquals('some_url', Arr::get($data, 'sections.0.endpoint.url'));
        });
    }
}
