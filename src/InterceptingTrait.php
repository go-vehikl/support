<?php namespace Vehikl\Traits;

trait InterceptingTrait
{
    public function __get($property)
    {
        return $this->getPropertyValue($property);
    }

    protected function getPropertyValue($property)
    {
        if ($this->hasInterceptingAccessor($property)) {
            return $this->getInterceptingAccessorValue($property);
        }
        return null;
    }

    protected function hasInterceptingAccessor($property)
    {
        $method = $this->getInterceptingAccessorName($property);
        return method_exists($this, $method) && is_callable([$this, $method]);
    }

    protected function getInterceptingAccessorValue($property)
    {
        $method = $this->getInterceptingAccessorName($property);
        return $this->$method();
    }

    protected function getInterceptingAccessorName($property)
    {
        return 'get'.studly_case($property) . 'Attribute';
    }

    public function __set($property, $value)
    {
        $this->setPropertyValue($property, $value);
    }

    protected function setPropertyValue($property, $value)
    {
        if ($this->hasInterceptingMutator($property)) {
            $this->setInterceptingMutatorValue($property, $value);
            return;
        }
        $this->{$property} = $value;
    }

    protected function hasInterceptingMutator($property)
    {
        $method = $this->getInterceptingMutatorName($property);
        return method_exists($this, $method) && is_callable([$this, $method]);
    }

    protected function setInterceptingMutatorValue($property, $value)
    {
        $method = $this->getInterceptingMutatorName($property);
        return $this->$method($value);
    }

    protected function getInterceptingMutatorName($property)
    {
        return 'set'.studly_case($property) . 'Attribute';
    }
}
