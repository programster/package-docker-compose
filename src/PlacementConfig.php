<?php

/*
 * An object to replements placement rules.
 * https://docs.docker.com/compose/compose-file/compose-file-v3/#placement
 */

namespace Programster\DockerCompose;

class PlacementConfig implements InterfaceArrayable
{
    private array $m_settings;


    /**
     * @TODO - come back and properly do this after looking up the possible options.
     * @param array $settings
     */
    public function __construct(array $settings)
    {
        $this->m_settings = $settings;
    }

    public function toArray(): array
    {
        return $this->m_settings;
    }
}