<?php

/*
 * An enum for the volume types. Based on:
 * https://docs.docker.com/storage/#more-details-about-mount-types
 */

namespace Programster\DockerCompose;


final class VolumeType implements \Stringable
{
    private string $m_type;


    public function __construct(string $type)
    {
        $this->m_type = $type;
    }

    public static function createVolume() : VolumeType { return new VolumeType("volume"); }
    public static function createBind() : VolumeType { return new VolumeType("bind"); }
    public static function createTmpfs() : VolumeType { return new VolumeType("tmpfs"); }
    public static function createNamedPipe() : VolumeType { return new VolumeType("npipe"); }


    public function __toString()
    {
        return $this->m_type;
    }
}
