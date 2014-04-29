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
}
