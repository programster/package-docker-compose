<?php

/*
 * A class to represent an extra host. These will be set in the built containers /etc/hosts file.
 */

namespace Programster\DockerCompose;


class ExtraHost implements Stringable, \JsonSerializable
{
    private string $m_host;
    private string $m_ipAddress;

    public function __construct(string $host, string $ipAddress)
    {
        if (filter_var($ipAddress, FILTER_VALIDATE_IP) === false)
        {
            throw new \Exception("You need to provide a valid ipv4 or ipv6 address when creating an ExtraHost object");
        }

        $this->m_host = $host;
        $this->m_ipAddress = $ipAddress;
    }


    public function __toString()
    {
        return "{$this->m_host}:{$this->m_ipAddress}";
    }

    
    public function jsonSerialize(): mixed
    {
        return (string)$this;
    }
}