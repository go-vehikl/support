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
        return $this->delegatee->{$property};
    }

    public function __set($property, $value)
    {
        $this->delegatee->{$property} = $value;
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->delegatee, $method], $parameters);
    }
}
