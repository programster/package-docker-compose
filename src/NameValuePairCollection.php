<?php


namespace Programster\DockerCompose;


final class NameValuePairCollection extends \ArrayObject
{
    public function __construct(NameValuePair ...$volumes)
    {
        parent::__construct($volumes);
    }


    public function append($value)
    {
        if ($value instanceof NameValuePair)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non NameValuePair to a " . __CLASS__);
        }
    }


    public function offsetSet($index, $newval)
    {
        if ($newval instanceof NameValuePair)
        {
            parent::offsetSet($index, $newval);
        }
        else
        {
            throw new Exception("Cannot add a non NameValuePair value to a " . __CLASS__);
        }
    }
}