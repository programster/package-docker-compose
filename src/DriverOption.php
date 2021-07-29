<?php

/*
 * Key value pairs to pass to the driver. These options are driver-dependent - consult the driver's documentation
 * for more information. Optional.
 */

namespace Programster\DockerCompose;


final class DriverOption implements InterfaceArrayable
{
    private string $m_name;
    private mixed $m_value;


    public function __construct(string $name, mixed $value)
    {
        $this->m_name = $name;
        $this->m_value = $value;
    }


    public function toArray(): array
    {
        return array($this->m_name => $this->m_value);
    }
}