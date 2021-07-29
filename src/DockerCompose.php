<?php

namespace Programster\DockerCompose;


final class DockerCompose implements \Stringable, InterfaceArrayable
{
    private array $m_services;
    private string $m_version;


    public function __construct(
        string $version = "3.8",
        Service ...$services
    )
    {
        $this->m_services = $services;
        $this->m_version = $version;

        foreach ($this->m_services as $service)
        {
            /* @var $service Service */

        }
    }


    public function toArray(): array
    {
        $arrayForm = array(
            'version' => $this->m_version,
        );

        if ($this->m_services !== null && count($this->m_services) > 0)
        {
            $servicesArray = [];

            foreach ($this->m_services as $service)
            {
                if (isset($servicesArray[$service->getName()]))
                {
                    throw new \Exception("You have two services named {$service->getName()}. Please give each service a unique name.");
                }

                $servicesArray[$service->getName()] = $service->toArray();
            }

            $arrayForm['services'] = $servicesArray;
        }

        return $arrayForm;
    }


    public function __toString()
    {
        return yaml_emit($this->toArray());
    }

}