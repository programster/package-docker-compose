<?php

/*
 * https://github.com/compose-spec/compose-spec/blob/master/spec.md#restart
 */

namespace Programster\DockerCompose;


class RestartEnum implements \Stringable, \JsonSerializable
{
    private string $m_value;


    private function __construct(string $value)
    {
        $this->m_value = $value;
    }


    public static function createNo() : RestartEnum
    {
        return new RestartEnum("no");
    }


    public static function createAlways() : RestartEnum
    {
        return new RestartEnum("always");
    }


    public static function createOnFailure() : RestartEnum
    {
        return new RestartEnum("on-failure");
    }


    public static function createUnlessStopped() : RestartEnum
    {
        return new RestartEnum("unless-stopped");
    }


    public function __toString()
    {
        return $this->m_value;
    }


    public function jsonSerialize(): mixed
    {
        return (string)$this;
    }
}