<?php

/*
 *
 */

namespace Programster\DockerCompose;


final class EnvironmentVariable implements \Stringable
{
    private string $m_name;
    private string $m_value;


    public function __construct(string $name, string|float|int|Stringable $value)
    {
        $this->m_name = $name;
        $this->m_value = $value;
    }

    public function __toString()
    {
        return "{$this->m_name}={$this->m_value}";
    }


    public function getName() : string { return $this->m_name; }
    public function getValue() : string  { return "$this->m_Value"; }
}
