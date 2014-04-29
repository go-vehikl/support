<?php namespace Vehikl\Traits;

trait InterceptingDelegatorTrait
{
    use DelegatingTrait {
        __get as delegatingGet;
        __set as delegatingSet;
    }
    use InterceptingTrait {
        __get as interceptingGet;
    }

    public function __get($property)
    {
        if ($this->hasInterceptingAccessor($property)) {
            return $this->interceptingGet($property);
        }
        return $this->delegatingGet($property);
    }

    public function __set($property, $value)
    {
        if ($this->hasInterceptingMutator($property)) {
            $this->setInterceptingMutatorValue($property, $value);
        }
        $this->delegatingSet($property, $value);
    }

    public function __call($method, $parameters)
    {

    }
}
