<?php


namespace Programster\DockerCompose;


final class Service implements InterfaceArrayable
{
    private string $m_name;
    private string $m_image;
    private ?PortCollection $m_ports = null;
    private ?RestartEnum $m_restart = null;
    private ?string $m_containerName = null;
    private ?VolumeCollection $m_volumes = null;
    private ?EnvironmentVariableCollection $m_environmentVariables = null;
    private ?string $m_command = null;
    private ?string $m_workingDir = null;
    private ?NetworkCollection $m_networks;
    private ?DeployConfig $m_deploymentConfig;
    private ?ServiceCollection $m_dependencies;

    /**
     *
     * @param string $name - the name for this service.
     * @param string $image - the image the service should deploy. E.g. "ubuntu:latest"
     * @param PortCollection|null $ports - the ports that should be opened up for the service.
     * @param RestartEnum|null $restart - configure when the container should restart itself.
     * @param string|null $containerName - the name to give the container.
     * @param VolumeConfig $volumes - volumes the container should mount.
     * @param EnvironmentVars $environment - environment variables to pass to the image.
     * @param Service $dependencies - other services this service depends on being running.
     * @param string|null $command
     * @param string|null $workingDir - overrides the container's working directory from that specified by the image.
     * E.g. Dockerfile WORKDIR
     */
    public function __construct(
        string $name,
        string $image,
        ?PortCollection $ports = null,
        ?RestartEnum $restart = null,
        ?string $containerName = null,
        ?VolumeCollection $volumes = null,
        ?EnvironmentVariableCollection $environmentVariables = null,
        ?string $command = null,
        ?string $workingDir = null,
        ?NetworkCollection $networks = null,
        ?DeployConfig $deploymentConfig = null,
        ?ServiceCollection $dependencies = null
    )
    {
        $this->m_name = $name;
        $this->m_image = $image;
        $this->m_ports = $ports;
        $this->m_restart = $restart;
        $this->m_containerName = $containerName;
        $this->m_volumes = $volumes;
        $this->m_environmentVariables = $environmentVariables;
        $this->m_command = $command;
        $this->m_workingDir = $workingDir;
        $this->m_networks = $networks;
        $this->m_deploymentConfig = $deploymentConfig;
        $this->m_dependencies = $dependencies;
    }


    public function getName() : string { return $this->m_name; }
    public function getNetworks() { return $this->m_networks; }

    public function toArray(): array
    {
        $arrayForm = array(
            'image' => $this->m_image,
        );

        if ($this->m_ports !== null && count($this->m_ports) > 0)
        {
            $arrayForm['ports'] = array();

            foreach ($this->m_ports as $port)
            {
                /* @var $port Port */
                $arrayForm['ports'][] = (string)$port;
            }
        }

        if ($this->m_restart !== null)
        {
            $arrayForm['restart'] = (string)$this->m_restart;
        }

        if ($this->m_containerName !== null)
        {
            $arrayForm['container_name'] = $this->m_containerName;
        }

        if ($this->m_volumes !== null)
        {
            $arrayForm['volumes'] = array();

            foreach ($this->m_volumes as $volume)
            {
                /* @var $volume \Programster\DockerCompose\Volume */
                $arrayForm['volumes'][] = $volume->toArray();
            }
        }

        if ($this->m_environmentVariables !== null && count($this->m_environmentVariables) > 0)
        {
            $environmentArray = [];

            foreach ($this->m_environmentVariables as $environmentVariable)
            {
                /* @var $environmentVariable EnvironmentVariable */
                $environmentArray[] = (string)$environmentVariable;

            }

            $arrayForm['environment'] = $environmentArray;
        }

        if ($this->m_command !== null)
        {
            $arrayForm['command'] = $this->m_command;
        }

        if ($this->m_workingDir !== null)
        {
            $arrayForm['workingDir'] = $this->m_workingDir;
        }

        if ($this->m_networks !== null)
        {
            $arrayForm['networks'] = $this->m_networks;
        }

        if ($this->m_deploymentConfig !== null)
        {
            $arrayForm['deploymentConfig'] = $this->m_deploymentConfig;
        }

        if ($this->m_dependencies !== null)
        {
            $arrayForm['dependencies'] = $this->m_dependencies;
        }

        return $arrayForm;
    }
}
