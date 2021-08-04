<?php

namespace Programster\DockerCompose;


final class DockerCompose implements \JsonSerializable, \Stringable, InterfaceArrayable
{
    private array $m_services;
    private string $m_version;
    private array $m_namedVolumeConfigs;


    public function __construct(
        string $version = "3.9",
        Service ...$services
    )
    {
        $this->m_services = $services;
        $this->m_version = $version;
        $this->m_namedVolumeConfigs = array();

        foreach ($this->m_services as $service)
        {
            /* @var $service Service */
            $volumes = $service->getVolumes();

            if ($volumes !== null && count($volumes) > 0)
            {
                foreach ($volumes as $volume)
                {
                    /* @var $volume Volume */
                    if ((string)$volume->getType() === (string)VolumeType::createVolume())
                    {
                        $newNamedVolumeConfig = $volume->getNamedVolumeConfig();

                        if (isset($this->m_namedVolumeConfigs[$newNamedVolumeConfig->getName()]))
                        {
                            $existingVolumeConfig = $this->m_namedVolumeConfigs[$newNamedVolumeConfig->getName()];

                            if ($existingVolumeConfig->getId() !== $newNamedVolumeConfig->getId())
                            {
                                $errMsg =
                                    "You have created two named volumes that share the same name, but which do " .
                                    "not share the same configuration. Either change one of their names, or " .
                                    "construct both of them with the same NamedVolumeConfig object";

                                throw new \Exception($errMsg);
                            }
                        }
                        else
                        {
                            $this->m_namedVolumeConfigs[$newNamedVolumeConfig->getName()] = $newNamedVolumeConfig;
                        }
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

                if (count($service->toArray()) > 0)
                {
                    $servicesArray[$service->getName()] = $service->toArray();
                }
                else
                {
                    $servicesArray[$service->getName()] = null;
                }
            }

            $arrayForm['services'] = $servicesArray;

            if (count($this->m_namedVolumeConfigs) > 0)
            {
                $arrayForm['volumes'] = array();

                foreach ($this->m_namedVolumeConfigs as $name => $volumeConfig)
                {
                    if (count($volumeConfig->toArray()) > 0)
                    {
                        $arrayForm['volumes'][$name] = $volumeConfig->toArray();
                    }
                    else
                    {
                        $arrayForm['volumes'][$name] = null;
                    }
                }
            }
        }

        return $arrayForm;
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }


    public function __toString()
    {
        $jsonEncoded = json_encode($this);
        $pureArrayForm = json_decode($jsonEncoded, true);
        return yaml_emit($pureArrayForm);
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