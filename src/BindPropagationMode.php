<?php

/*
 * An enum for the various bind propagation modes. This only affects Linux hosts
 * More info at: https://docs.docker.com/storage/bind-mounts/#configure-bind-propagation
 */

namespace Programster\DockerCompose;


final class BindPropagationMode implements \Stringable
{
    private string $m_mode;


    private function __construct(string $mode)
    {
        $this->m_mode = $mode;
    }


    /**
     * Sub-mounts of the original mount are exposed to replica mounts, and sub-mounts of replica mounts are also
     * propagated to the original mount.
     * @return BindPropagationMode
     */
    public static function createShared() : BindPropagationMode { return new BindPropagationMode("shared"); }


    /**
     * Similar to a shared mount, but only in one direction. If the original mount exposes a sub-mount, the replica
     * mount can see it. However, if the replica mount exposes a sub-mount, the original mount cannot see it.
     * @return BindPropagationMode
     */
    public static function createSlave() : BindPropagationMode { return new BindPropagationMode("slave"); }


    /**
     * The mount is private. Sub-mounts within it are not exposed to replica mounts, and sub-mounts of replica mounts
     * are not exposed to the original mount.
     * @return BindPropagationMode
     */
    public static function createPrivate() : BindPropagationMode { return new BindPropagationMode("private"); }


    /**
     * The same as shared, but the propagation also extends to and from mount points nested within any of the original
     * or replica mount points.
     * @return BindPropagationMode
     */
    public static function createRshared() : BindPropagationMode { return new BindPropagationMode("rshared"); }


    /**
     * The same as slave, but the propagation also extends to and from mount points nested within any of the original
     * or replica mount points.
     * @return BindPropagationMode
     */
    public static function createRslave() : BindPropagationMode { return new BindPropagationMode("rslave"); }


    /**
     * The default. The same as private, meaning that no mount points anywhere within the original or replica mount
     * points propagate in either direction.
     * @return BindPropagationMode
     */
    public static function createRprivate() : BindPropagationMode { return new BindPropagationMode("rprivate"); }





    public function __toString() { return $this->m_mode; }
}

