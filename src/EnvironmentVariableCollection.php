<?php


namespace Programster\DockerCompose;


final class EnvironmentVariableCollection extends \ArrayObject
{
    public function __construct(EnvironmentVariable ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof EnvironmentVariable)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non EnvironmentVariable to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof EnvironmentVariable)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non EnvironmentVariable value to a " . __CLASS__);
        }
    }
}