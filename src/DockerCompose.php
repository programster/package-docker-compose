<?php

namespace Programster\DockerCompose;


final class DockerCompose implements \Stringable, InterfaceArrayable
{
    private array $m_services;
    private string $m_version;
    private array $m_volumes;


    public function __construct(
        string $version = "3.9",
        Service ...$services
    )
    {
        $this->m_services = $services;
        $this->m_version = $version;
        $this->m_volumes = array();

        foreach ($this->m_services as $service)
        {
            /* @var $service Service */
            $volumes = $service->getVolumes();

            if ($volumes !== null && count($volumes) > 0)
            {
                foreach ($volumes as $volume)
                {
                    /* @var $volume Volume */
                    if ($volume->getName() !== null)
                    {
                        $this->m_volumes[$volume->getName()] = $volume;
                    }
                }
            }
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

            // @TODO - add proper support for volumes, allowing the user to specify drivers etc.
            if (count($this->m_volumes) > 0)
            {
                $arrayForm['volumes'] = array();

                foreach ($this->m_volumes as $name => $volume)
                {
                    $volumeArray = array(
                        'driver' => $volume->getDriver()
                    );

                    if (count($volume->getDriverOptions()) > 0)
                    {
                        foreach ($volume->getDriverOptions() as $option)
                        {
                            /* @var $option DriverOption */
                            $volumeArray['driver_opts'][] = $option->toArray();
                        }
                    }

                    $arrayForm['volumes'][$name] = $volumeArray;
                }
            }
        }

        return $arrayForm;
    }


    public function __toString()
    {
        return yaml_emit($this->toArray());
    }


    /**
     * Save this to a file.
     * @param string $filepath
     */
    public function save(string $filepath) : void
    {
        file_put_contents($filepath, string($this));
    }
}