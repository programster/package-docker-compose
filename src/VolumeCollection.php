<?php


namespace Programster\DockerCompose;


final class VolumeCollection extends \ArrayObject
{
    public function __construct(Volume ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof Volume)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Volume to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof Volume)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non volume value to a " . __CLASS__);
        }
    }
}