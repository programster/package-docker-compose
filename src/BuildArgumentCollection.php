<?php

/*
 * A collection of build arguments.
 */


namespace Programster\DockerCompose;


final class BuildArgumentCollection extends \ArrayObject
{
    public function __construct(BuildArgument ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof BuildArgument)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non BuildArgument to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof BuildArgument)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non BuildArgument value to a " . __CLASS__);
        }
    }
}