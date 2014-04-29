<?php

use Vehikl\Traits\InterceptingTrait;

class InterceptingTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_can_get_magic_property_value()
    {
        $stub = new InterceptingStub;
        $this->assertSame('bar', $stub->foo);
    }

    public function test_undefined_property_returns_null()
    {
        $stub = new InterceptingStub;
        $this->assertNull($stub->bar);
    }

    public function test_can_set_magic_property_value()
    {
        $stub = new InterceptingStub;
        $stub->foo = 'baz';
        $this->assertSame('baz intercepted', $stub->foo);
    }

    public function test_can_set_non_magic_property_value()
    {
        $stub = new InterceptingStub;
        $stub->bar = 'baz';
        $this->assertSame('baz', $stub->bar);
    }
}

class InterceptingStub
{
    use InterceptingTrait;

    protected $foo = 'bar';

    public function getFooAttribute()
    {
        return $this->foo;
    }

    public function setFooAttribute($value)
    {
        $this->foo = $value . " intercepted";
    }
}
