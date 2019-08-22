<?php

namespace Signifly\Travy\Test\Unit\Support;

use Signifly\Travy\Support\Input;
use Signifly\Travy\Test\TestCase;
use Illuminate\Support\Collection;

class InputTest extends TestCase
{
    /** @test */
    public function it_can_interact_with_input_data()
    {
        $input = new Input([
            'name' => 'John Doe',
            'email' => 'john.doe@example.org',
            'text' => '   a   ',
            'company' => [
                'name' => 'Apple',
            ],
            'nullable' => null,
            'empty' => '',
        ], []);

        // Assert Input::has
        $this->assertTrue($input->has('name'));
        $this->assertTrue($input->has('email'));
        $this->assertTrue($input->has('text'));
        $this->assertTrue($input->has('company.name'));
        $this->assertFalse($input->has('invalid_key'));
        $this->assertFalse($input->has('company.invalid_key'));

        // Assert Input::get
        $this->assertEquals('John Doe', $input->get('name'));
        $this->assertEquals('john.doe@example.org', $input->get('email'));
        $this->assertEquals('   a   ', $input->get('text'));
        $this->assertEquals('Apple', $input->get('company.name'));

        // Assert Input::filled
        $this->assertTrue($input->filled('name'));
        $this->assertFalse($input->filled('invalid_key'));
        $this->assertFalse($input->filled('nullable'));
        $this->assertFalse($input->filled('empty'));

        // Assert Input::only
        $this->assertEquals(['name' => 'John Doe'], $input->only('name'));

        // Assert Input::except
        $this->assertEquals([
            'name' => 'John Doe',
            'nullable' => null,
            'empty' => '',
        ], $input->except(['email', 'text', 'company']));

        // Assert Input::collect
        $this->assertInstanceOf(Collection::class, $input->collect('company'));

        // Assert ArrayAccess and magic methods implementation
        $this->assertEquals('John Doe', $input->name);
        $this->assertEquals('John Doe', $input['name']);
    }

    /** @test */
    public function it_can_sanitize_data()
    {
        $input = new Input([
            'is_real' => 1,
            'text' => '   a   ',
        ], [
            'is_real' => 'cast:bool',
            'text' => 'trim',
        ]);

        $this->assertEquals(true, $input->get('is_real'));
        $this->assertEquals('a', $input->get('text'));
    }
}
