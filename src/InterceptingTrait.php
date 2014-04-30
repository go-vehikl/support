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
        $base_value = $this->getBasePropertyValue($property);
        return $this->$method($base_value);
    }

    protected function getInterceptingAccessorName($property)
    {
        return 'get'.$this->studlyCase($property) . 'Attribute';
    }

    protected function getBasePropertyValue($property)
    {
        return property_exists($this, $property) ? $this->{$property} : null;
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
        return 'set'.$this->studlyCase($property) . 'Attribute';
    }

    protected function studlyCase($value)
    {
        $value = ucwords(str_replace(array('-', '_'), ' ', $value));
        return str_replace(' ', '', $value);
    }

    public function __isset($property)
    {
        return $this->hasInterceptingAccessor($property) || isset($this->{$property});
    }
}
