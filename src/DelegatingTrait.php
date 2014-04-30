<?php namespace Vehikl\Traits;

trait DelegatingTrait
{
    protected $delegatee;

    public function __construct($delegatee)
    {
        $this->delegatee = $delegatee;
    }

    public function __get($property)
    {
        return $this->getDelegateeProperty($property);
    }

    protected function getDelegateeProperty($property)
    {
        if (! isset($this->delegatee->{$property})) {
            return null;
        }
        return $this->delegatee->{$property};
    }

    public function __set($property, $value)
    {
        $this->setDelegateeProperty($property, $value);
    }

    protected function setDelegateeProperty($property, $value)
    {
        $this->delegatee->{$property} = $value;
    }

    public function __call($method, $parameters)
    {
        return $this->callDelegateeMethod($method, $parameters);
    }

    protected function callDelegateeMethod($method, $parameters)
    {
        return call_user_func_array([$this->delegatee, $method], $parameters);
    }
}
