<?php

use Vehikl\Traits\InterceptingDelegatorTrait;

class InterceptingDelegatorTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_it_delegates_getting_properties()
    {
        $object = new InterceptingDelegator(new Foo);
        $this->assertSame('baz', $object->bar);
    }

    public function test_it_delegates_setting_properties()
    {
        $foo = new Foo;
        $object = new InterceptingDelegator($foo);
        $object->bar = 'whizzle';
        $this->assertSame('whizzle', $object->bar);
    }
}

class InterceptingDelegator
{
    use InterceptingDelegatorTrait;
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
