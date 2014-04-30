<?php

use Vehikl\Traits\InterceptingDelegatorTrait;
use Vehikl\Traits\InterceptingTrait;

class InterceptingDelegatorTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_it_delegates_getting_properties()
    {
        $object = new InterceptingDelegator(new Baz);
        $this->assertSame('baz', $object->bar);
    }

    public function test_it_delegates_setting_properties()
    {
        $foo = new Baz;
        $object = new InterceptingDelegator($foo);
        $object->bar = 'whizzle';
        $this->assertSame('whizzle', $object->bar);
    }

    public function test_it_intercepts_getting_properties()
    {
        $object = new InterceptingDelegator(new Baz);
        $this->assertSame('expected value', $object->baz);
    }

    public function test_intercepting_accessors_can_use_delegate_value()
    {
        $foo = new Baz;
        $foo->buzz = 'hello';
        $object = new InterceptingDelegator($foo);
        $this->assertSame('hello world', $object->buzz);
    }

    public function test_it_intercepts_setting_properties()
    {
        $object = new InterceptingDelegator(new Baz);
        $object->foo = 'foo';
        $this->assertSame('foo intercepted', $object->foo);
    }

    public function test_it_delegates_method_calls()
    {
        $object = new InterceptingDelegator(new Baz);
        $this->assertSame('some text', $object->foobar('some', 'text'));
    }

    public function test_can_properly_delegate_to_another_class_using_an_interceptor_for_an_undefined_property()
    {
        $object = new InterceptingDelegator(new Foobar);
        $this->assertSame('hello world', $object->buzz);
    }
}

class InterceptingDelegator
{
    use InterceptingDelegatorTrait;

    protected $foo;

    public function getBazAttribute()
    {
        return 'expected value';
    }

    public function setFooAttribute($value)
    {
        $this->foo = $value . " intercepted";
    }

    public function getFooAttribute()
    {
        return $this->foo;
    }

    public function getBuzzAttribute($value)
    {
        return $value . ' world';
    }
}

class Baz
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

class Foobar
{
    use InterceptingTrait;

    public function getBuzzAttribute()
    {
        return 'hello';
    }
}
