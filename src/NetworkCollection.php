<?php


namespace Programster\DockerCompose;


final class NetworkCollection extends \ArrayObject
{
    public function __construct(Network ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof Network)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Network to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof Network)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non Network value to a " . __CLASS__);
        }
    }
}