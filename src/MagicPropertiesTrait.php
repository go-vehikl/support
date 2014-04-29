<?php namespace Vehikl\Traits;

trait MagicPropertiesTrait
{
    public function __get($property)
    {
        return $this->getAttributeValue($property);
    }

    protected function getAttributeValue($property)
    {
        $method = 'get'.studly_case($property) . 'Attribute';
        if (method_exists($this, $method) && is_callable([$this, $method])) {
            return $this->$method();
        }
        return null;
    }

    public function __set($property, $value)
    {
        $this->setAttributeValue($property, $value);
    }

    protected function setAttributeValue($property, $value)
    {
        $method = 'set' . studly_case($property) . 'Attribute';
        if (method_exists($this, $method) && is_callable([$this, $method])) {
            $this->$method($value);
            return;
        }
        $this->{$property} = $value;
    }
}
