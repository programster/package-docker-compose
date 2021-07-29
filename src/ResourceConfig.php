<?php

/*
 * Key value pairs to pass to the driver. These options are driver-dependent - consult the driver's documentation
 * for more information. Optional.
 */

namespace Programster\DockerCompose;


final class ResourceConfig implements InterfaceArrayable
{
    private float $m_cpuLimit;
    private float $m_cpuReservation;
    private int $m_memoryLimit;
    private int $m_memoryReservation;


    public function __construct(
        ?float $cpuLimit = null,
        ?float $cpuReservation,
        ?int $memoryLimit = null,
        ?int $memoryReservation = null
    )
    {
        $this->m_cpuLimit = $cpuLimit;
        $this->m_cpuReservation = $cpuReservation;
        $this->m_memoryLimit = $memoryLimit;
        $this->m_memoryReservation = $memoryReservation;
    }


    public function toArray(): array
    {
        $limits = array();
        $reservations = array();


        if ($this->m_cpuLimit !== null)
        {
            $limits['cpus'] = $this->m_cpuLimit;
        }

        if ($this->m_memoryLimit !== null)
        {
            $limits['memory'] = $this->m_memoryLimit . "M";
        }

        if ($this->m_cpuReservation !== null)
        {
            $reservations['cpus'] = $this->m_cpuReservation;
        }

        if ($this->m_memoryReservation !== null)
        {
            $reservations['memory'] = $this->m_memoryReservation . "M";
        }

        $arrayForm = [];

        if (count($limits) > 0)
        {
            $arrayForm['limits'] = $limits;
        }

        if (count($reservations) > 0)
        {
            $arrayForm['reservations'] = $reservations;
        }

        return $arrayForm;
    }
}