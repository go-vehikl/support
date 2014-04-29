<?php

use Vehikl\Traits\MagicPropertiesTrait;

class MagicPropertiesTraitTest extends PHPUnit_Framework_TestCase
{
    public function test_can_get_magic_property_value()
    {
        $stub = new MagicPropertiesStub;
        $this->assertSame('bar', $stub->foo);
    }

    public function test_undefined_property_returns_null()
    {
        $stub = new MagicPropertiesStub;
        $this->assertNull($stub->bar);
    }

    public function test_can_set_magic_property_value()
    {
        $stub = new MagicPropertiesStub;
        $stub->foo = 'baz';
        $this->assertSame('baz', $stub->foo);
    }

    public function test_can_set_non_magic_property_value()
    {
        $stub = new MagicPropertiesStub;
        $stub->bar = 'baz';
        $this->assertSame('baz', $stub->bar);
    }
}

class MagicPropertiesStub
{
    use MagicPropertiesTrait;

    protected $foo = 'bar';

    public function getFooAttribute()
    {
        return $this->foo;
    }

    public function setFooAttribute($value)
    {
        $this->foo = $value;
    }
}
