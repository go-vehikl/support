<?php

use Vehikl\Traits\DecoratingTrait;

class DecoratingTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_it_delegates_properties()
    {
        $decorator = new FooDecorator(new Foo);
        $this->assertSame('baz', $decorator->bar);
    }

    public function test_it_delegates_method_calls()
    {
        $decorator = new FooDecorator(new Foo);
        $this->assertSame('foobar', $decorator->baz());
    }
}

class FooDecorator
{
    use DecoratingTrait;
}

class Foo
{
    public $bar = 'baz';

    public function baz()
    {
        return 'foobar';
    }
}
