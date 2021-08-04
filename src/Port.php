<?php

/*
 *
 */

namespace Programster\DockerCompose;


final class Port implements \Stringable, \JsonSerializable
{
    private int $m_containerPort;
    private ?int $m_hostPort;


    /**
     *
     * @param int $containerPort - the port in the container
     * @param int|null $hostPort - the host port that should map to the container port. Set a value of null if you wish
     * for docker to randomly assign a port.
     */
    public function __construct(int $containerPort, ?int $hostPort)
    {
        $this->m_containerPort = $containerPort;
        $this->m_hostPort = $hostPort;
    }


    public function __toString()
    {
        return ($this->m_hostPort !== null) ? "{$this->m_hostPort}:{$this->m_containerPort}" : "{$this->m_containerPort}";
    }

    
    public function jsonSerialize(): mixed
    {
        return (string)$this;
    }
}

