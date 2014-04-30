<?php

use Vehikl\Support\DelegatingTrait;

class DelegatingTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_it_delegates_getting_properties()
    {
        $decorator = new FooDelegator(new Foo);
        $this->assertSame('baz', $decorator->bar);
    }

    public function test_it_delegates_setting_properties()
    {
        $foo = new Foo;
        $decorator = new FooDelegator($foo);
        $decorator->bar = 'whizzle';
        $this->assertSame('whizzle', $foo->bar);
    }

    public function test_it_delegates_method_calls()
    {
        $decorator = new FooDelegator(new Foo);
        $this->assertSame('foobar', $decorator->baz());
    }

    public function test_it_delegates_method_calls_with_parameters()
    {
        $decorator = new FooDelegator(new Foo);
        $this->assertSame('something else', $decorator->foobar('something', 'else'));
    }
}

class FooDelegator
{
    use DelegatingTrait;
}

class Foo
{
    public $bar = 'baz';

    public function baz()
    {
        return 'foobar';
    }

    public function foobar($bar, $baz)
    {
        return "{$bar} {$baz}";
    }
}
