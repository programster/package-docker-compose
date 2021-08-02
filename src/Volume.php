<?php

/*
 *
 */

namespace Programster\DockerCompose;


final class Volume implements InterfaceArrayable
{
    private string $m_type;
    private string $m_containerPath;
    private ?string $m_name = null;
    private ?string $m_hostPath = null; // path on host. May not be set in case of "named volumes"
    private bool $m_isReadOnly = false;
    private ?BindPropagationMode $m_bindPropagationMode = null;
    private bool $m_createHostPath;
    private string $m_driver;
    private array $m_driverOptions;
    private ?string $m_consistency = null;
    private ?bool $m_noCopy = null;
    private ?int $m_tmpfsSize = null;


    private function __construct(){}


    /**
     * Create a named volume.
     * @param string $name
     * @param string $containerPath
     * @param bool $isReadOnly
     * @param bool $noCopy
     * @param string|null $consistency
     * @return Volume
     */
    public static function createNamedVolume(
        string $name,
        string $containerPath,
        bool $isReadOnly = false,
        bool $noCopy = false,
        ?Consistency $consistency = null,
        string $driver = "local",
        DriverOption ...$driverOptions
    ) : Volume
    {
        $volume = new Volume();
        $volume->m_type = VolumeType::createVolume();
        $volume->m_name = $name;
        $volume->m_containerPath = $containerPath;
        $volume->m_isReadOnly = $isReadOnly;
        $volume->m_noCopy = $noCopy;
        $volume->m_driver = $driver;
        $volume->m_driverOptions = $driverOptions;
        return $volume;
    }


    public static function createNormal(
        string $hostPath,
        string $containerPath,
        bool $isReadOnly = false,
        bool $noCopy = false,
        ?Consistency $consistency = null,
        string $driver = "local",
        DriverOption ...$driverOptions
    ) : Volume
    {
        $volume = new Volume();
        $volume->m_type = VolumeType::createVolume();
        $volume->m_hostPath = $hostPath;
        $volume->m_containerPath = $containerPath;
        $volume->m_isReadOnly = $isReadOnly;
        $volume->m_noCopy = $noCopy;
        $volume->m_driver = $driver;
        $volume->m_driverOptions = $driverOptions;
        return $volume;
    }


    /**
     * Create a bind mounted volume. This is the way docker originally mounted volumes. When you use a bind mount,
     * a file or directory on the host machine is mounted into a container. The file or directory is referenced by its
     * absolute path on the host machine. By contrast, when you use a volume, a new directory is created within Docker’s
     * storage directory on the host machine, and Docker manages that directory’s contents. The file or directory does
     * not need to exist on the Docker host already. It is created on demand if it does not yet exist. Bind mounts are
     * very performant, but they rely on the host machine’s filesystem having a specific directory structure available.
     * If you are developing new Docker applications, consider using named volumes instead. You can’t use Docker CLI
     * commands to directly manage bind mounts.
     * https://docs.docker.com/storage/bind-mounts/
     * @param string $hostPath - the path on the host the should be mounted within the container
     * @param string $containerPath - the path inside the container that the hostPaths should be mounted to
     * @param bool $isReadOnly - whether the container can only read from the volume instead of read-write.
     * @param bool $createHostPath - create a directory at the source path on host if there is nothing present.
     * Do nothing if there is something present at the path.
     * @param BindPropagationMode|null $propagationMode - optionally specify the propagation mode used for the bind
     * @return Volume
     */
    public static function createBindVolume(
        string $hostPath,
        string $containerPath,
        bool $isReadOnly = false,
        bool $createHostPath = true,
        ?BindPropagationMode $propagationMode = null,
        ?Consistency $consistency = null,
        string $driver = "local",
        DriverOption ...$driverOptions
    ) : Volume
    {
        $volume = new Volume();
        $volume->m_type = VolumeType::createBind();
        $volume->m_hostPath = $hostPath;
        $volume->m_containerPath = $containerPath;
        $volume->m_name = null;
        $volume->m_isReadOnly = $isReadOnly;
        $volume->m_bindPropagationMode = $propagationMode;
        $volume->m_createHostPath = $createHostPath;
        $volume->m_driver = $driver;
        $volume->m_driverOptions = $driverOptions;
        $volume->m_consistency = $consistency;
        $volume->m_noCopy = null;
        return $volume;
    }


    /**
     * Create a tmpfs mount. As opposed to volumes and bind mounts, a tmpfs mount is temporary, and only persisted in
     * the host memory. When the container stops, the tmpfs mount is removed, and files written there won’t be
     * persisted. This is useful to temporarily store sensitive files that you don’t want to persist in either the host
     * or the container writable layer. It should also be very quick as its only in memory!
     * https://docs.docker.com/storage/tmpfs/
     * @param string $containerPath - the path within the container that the volume should mount to.
     * @param bool $isReadOnly - whether the volume should be read-only.
     * @param int|null $sizeInBytes - optionally set a size in bytes for the temporary filesystem.
     * @param string|null $consistency - the consistency requirements of the mount. Available values are platform specific
     * @return Volume
     */
    public static function createTmpfs(
        string $containerPath,
        bool $isReadOnly = false,
        ?int $sizeInBytes = null,
        ?Consistency $consistency = null,
        string $driver = "local",
        DriverOption ...$driverOptions
    ) : Volume
    {
        $volume = new Volume();
        $volume->m_type = VolumeType::createTmpfs();
        $volume->m_containerPath = $containerPath;
        $volume->m_isReadOnly = $isReadOnly;
        $volume->m_tmpfsSize = $sizeInBytes;
        $volume->m_driver = $driver;
        $volume->m_driverOptions = $driverOptions;
        $volume->m_consistency = $consistency;
        $volume->m_noCopy = null;
        return $volume;
    }


    /**
     * Windows only - This type of volume can be used for communication between the Docker host and a container.
     * Common use case is to run a third-party tool inside of a container and connect to the Docker Engine API using a
     * named pipe. https://docs.microsoft.com/en-us/windows/win32/ipc/named-pipes
     * @param string $hostPath - the folder on the host that should be mounted
     * @param string $containerPath - the path within the container that the volume should mount to.
     * @param bool $isReadOnly - whether the volume should be read-only.
     * @param string|null $consistency - the consistency requirements of the mount. Available values are platform specific
     * @return Volume
     */
    public static function createNamedPipe(
        string $hostPath,
        string $containerPath,
        bool $isReadOnly = false,
        ?Consistency $consistency = null,
        string $driver = "local",
        DriverOption ...$driverOptions
    ) : Volume
    {
        $volume = new Volume();
        $volume->m_type = VolumeType::createNamedPipe();
        $volume->m_hostPath = $hostPath;
        $volume->m_containerPath = $containerPath;
        $volume->m_isReadOnly = $isReadOnly;
        $volume->m_consistency = $consistency;
        $volume->m_driver = $driver;
        $volume->m_driverOptions = $driverOptions;
        return $volume;
    }


    /**
     * Create an array representation of this object.
     * @return array
     */
    public function toArray(): array
    {
        $arrayForm = array(
            'type' => $this->m_type,
            'target' => $this->m_containerPath,
        );

        if ($this->m_name !== null)
        {
            $arrayForm['source'] = $this->m_name;
        }

        if ($this->m_hostPath !== null)
        {
            $arrayForm['source'] = $this->m_hostPath;
        }

        if ($this->m_isReadOnly)
        {
            $arrayForm['read_only'] = true;
        }

        if ($this->m_noCopy !== null && $this->m_noCopy === true)
        {
            if (!isset($arrayForm['volume']))
            {
                $arrayForm['volume'] = array();
            }

            $arrayForm['volume']['nocopy'] = true;
        }

        if ($this->m_bindPropagationMode !== null)
        {
            if (!isset($arrayForm['bind']))
            {
                $arrayForm['bind'] = array();
            }

            $arrayForm['bind']['propagation'] = $this->m_bindPropagationMode;
        }

        if ($this->m_tmpfsSize !== null)
        {
            if (!isset($arrayForm['tmpfs']))
            {
                $arrayForm['tmpfs'] = array();
            }

            $arrayForm['tmpfs']['size'] = $this->m_tmpfsSize;
        }

        return $arrayForm;
    }


    # Accessors
    public function getName() : ?string { return $this->m_name; }
    public function getType() : string { return $this->m_type; }
    public function getDriver() : string { return $this->m_driver; }
    public function getDriverOptions() : array { return $this->m_driverOptions; }
}
