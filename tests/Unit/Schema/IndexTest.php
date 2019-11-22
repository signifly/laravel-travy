<?php

namespace Signifly\Travy\Test\Unit\Schema;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Signifly\Travy\Schema\Index;
use Signifly\Travy\Test\TestCase;
use Signifly\Travy\Concerns\WithModifiers;

class IndexTest extends TestCase
{
    /** @test */
    public function it_serializes_to_json()
    {
        // Arrange
        $request = app(Request::class);
        $index = new ShopIndex($request);

        // Act
        $schema = $index->jsonSerialize();

        // Assert
        $this->assertArrayHasKey('pageTitle', $schema);
        $this->assertArrayHasKey('hero', $schema);
        $this->assertArrayHasKey('tabs', $schema);
        $this->assertArrayNotHasKey('modifiers', $schema);

        $this->assertEquals('Shops', Arr::get($schema, 'pageTitle'));
        $this->assertEquals('Welcome back, {name}', Arr::get($schema, 'hero.title'));
    }

    /** @test */
    public function it_can_include_modifiers()
    {
        // Arrange
        $request = app(Request::class);
        $index = new ModifierShopIndex($request);

        // Act
        $schema = $index->jsonSerialize();

        // Assert
        $this->assertArrayHasKey('pageTitle', $schema);
        $this->assertArrayHasKey('hero', $schema);
        $this->assertArrayHasKey('tabs', $schema);
        $this->assertArrayHasKey('modifiers', $schema);

        $this->assertEquals('Shops', Arr::get($schema, 'pageTitle'));
        $this->assertEquals('Welcome back, {name}', Arr::get($schema, 'hero.title'));
    }
}

class ShopIndex extends Index
{
    public function pageTitle(): string
    {
        return 'Shops';
    }

    public function hero(): array
    {
        return [
            'title' => 'Welcome back, {name}',
            'subtitle' => 'Lorem ipsum bla bla bla bla',
        ];
    }

    public function tabs(): array
    {
        return [];
    }
}

class ModifierShopIndex extends ShopIndex implements WithModifiers
{
    public function modifiers(): array
    {
        return [
            'data' => (object) [],
            'fields' => (object) [],
        ];
    }
}
