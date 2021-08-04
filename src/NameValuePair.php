<?php

/*
 * Key value pairs to pass to the driver. These options are driver-dependent - consult the driver's documentation
 * for more information. Optional.
 */

namespace Programster\DockerCompose;


final class NameValuePair implements InterfaceArrayable, \JsonSerializable
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

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    
    # Accessors
    public function getName() : string { return $this->m_name; }
    public function getValue() : mixed { return $this->m_value; }
}