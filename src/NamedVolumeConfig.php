<?php

/*
 *
 */

namespace Programster\DockerCompose;


final class NamedVolumeConfig implements InterfaceArrayable, \JsonSerializable
{
    private static $s_counter = 0;
    private int $m_id;
    private string $m_name;
    private ?string $m_driver;
    private array $m_driverOptions;


    public function __construct(
        string $name,
        ?string $driver = null,
        NameValuePair ...$driverOptions,
    )
    {
        NamedVolumeConfig::$s_counter++;
        $this->m_id = NamedVolumeConfig::$s_counter;
        $this->m_name = $name;
        $this->m_driver = $driver;
        $this->m_driverOptions = $driverOptions;
    }


    public function toArray(): array
    {
        $arrayForm = array();

        if ($this->m_driver !== null)
        {
            $arrayForm['driver'] = $this->m_driver;

            if (count($this->m_driverOptions()) > 0)
            {
                $arrayForm['driver_opts'] = array();

                foreach ($this->m_driverOptions as $option)
                {
                    /* @var $option NameValuePair */
                    $arrayForm['driver_opts'][] = $option->toArray();
                }
            }
        }

        return $arrayForm;
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }


    # Accessors
    public function getId() : int { return $this->m_id; }
    public function getName() : string { return $this->m_name; }
    public function getDriver() : string { return $this->m_driver; }
    public function getDriverOptions() : array { return $this->m_driverOptions; }
}
