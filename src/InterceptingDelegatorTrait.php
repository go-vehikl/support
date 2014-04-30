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
        if ($this->hasInterceptingAccessor($property)) {
            return $this->getInterceptingAccessorValue($property);
        }
        return $this->delegatingGet($property);
    }

    protected function getBasePropertyValue($property)
    {
        return $this->delegatingGet($property);
    }

    public function __set($property, $value)
    {
        if ($this->hasInterceptingMutator($property)) {
            $this->setInterceptingMutatorValue($property, $value);
        }
        $this->delegatingSet($property, $value);
    }
}
