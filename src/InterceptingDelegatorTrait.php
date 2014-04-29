<?php namespace Vehikl\Traits;

trait InterceptingDelegatorTrait
{
    use DelegatingTrait {
        __get as delegatingGet;
        __set as delegatingSet;
    }
    use InterceptingTrait;

    public function __get($property)
    {
        $delegatee_value = $this->delegatingGet($property);
        if ($this->hasInterceptingAccessor($property)) {
            return $this->getInterceptingAccessorValue($property, $delegatee_value);
        }
        return $delegatee_value;
    }

    public function __set($property, $value)
    {
        if ($this->hasInterceptingMutator($property)) {
            $this->setInterceptingMutatorValue($property, $value);
        }
        $this->delegatingSet($property, $value);
    }
}
