<?php


namespace Programster\DockerCompose;


final class PortCollection extends \ArrayObject
{
    public function __construct(Port ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof Port)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Port to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof Port)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non Port value to a " . __CLASS__);
        }
    }
}