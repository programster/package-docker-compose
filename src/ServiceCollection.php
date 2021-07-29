<?php


namespace Programster\DockerCompose;


final class ServiceCollection extends \ArrayObject
{
    public function __construct(Service ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof Service)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Service to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof Service)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non Service value to a " . __CLASS__);
        }
    }
}