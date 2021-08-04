<?php


namespace Programster\DockerCompose;


final class ExtraHostCollection extends \ArrayObject
{
    public function __construct(ExtraHost ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof ExtraHost)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non ExtraHost to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof ExtraHost)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non ExtraHost value to a " . __CLASS__);
        }
    }
}