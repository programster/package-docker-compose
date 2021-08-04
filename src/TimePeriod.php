<?php

/*
 * Create a time duration. Required for various aspects of a config.
 */

namespace Programster\DockerCompose;

class TimePeriod implements \Stringable, \JsonSerializable
{
    private int $m_numUnits;
    private TimeUnit $m_unitType;


    public function __construct(int $numUnits, TimeUnit $unitType)
    {
        $this->m_numUnits = $numUnits;
        $this->m_unitType = $unitType;
    }


    public function __toString() { return "{$numUnits}{$unitType}"; }

    
    public function jsonSerialize(): mixed
    {
        return (string)$this;
    }
}