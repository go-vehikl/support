<?php namespace Vehikl\Traits;

trait DecoratingTrait
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public function __get($property)
    {
        return $this->object->{$property};
    }

    public function __set($property, $value)
    {
        $this->object->{$property} = $value;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->object, $method], $parameters);
    }
}
