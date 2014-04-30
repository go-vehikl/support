<?php

use Vehikl\Support\InterceptingTrait;

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

    public function test_it_passes_non_public_properties_into_accessors()
    {
        $stub = new InterceptingStub;
        $this->assertSame('whizzle mutated', $stub->baz);
    }

    public function test_accessors_are_considered_set_properties()
    {
        $stub = new InterceptingStub;
        $this->assertTrue(isset($stub->foobar));
    }
}

class InterceptingStub
{
    use InterceptingTrait;

    protected $foo = 'bar';
    protected $baz = 'whizzle';

    public function getFooAttribute()
    {
        return $this->foo;
    }

    public function setFooAttribute($value)
    {
        $this->foo = $value . " intercepted";
    }

    public function getBazAttribute($value)
    {
        return $value . ' mutated';
    }

    public function getFoobarAttribute()
    {
        return 'foobar';
    }
}
