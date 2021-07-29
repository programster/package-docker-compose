<?php

/*
 * A class to represent a named network.
 */

namespace Programster\DockerCompose;


final class Network implements InterfaceArrayable
{
    private string $m_name;
    private ?string $m_driver;
    private ?bool $m_isExternal;
    private bool $m_isAttachable;
    private ?bool $m_enableIpv6;



    /**
     *
     * @param string $name - the name to give the network.
     * @param string|null $driver - the driver the network should use. Unfortunately, default and available values are
     * platform specific so an enum cannot be provided, but "host", and "none" must be supported, with host using the
     * host's networking, and none disabling networking. https://github.com/compose-spec/compose-spec/blob/master/spec.md#driver
     * @param bool|null $isExternal -
     * @param bool $isAttachable - If attachable is set to true, then standalone containers SHOULD be able attach
     * to this network, in addition to services. If a standalone container attaches to the network, it can communicate
     * with services and other standalone containers that are also attached to the network.
     */
    public function __construct(
        string $name,
        ?string $driver = null,
        bool $isAttachable = false,
        ?bool $isExternal = null,
        ?bool $enableIpv6 = null
    )
    {
        $this->m_name = $name;
        $this->m_driver = $driver;
        $this->m_isExternal = $isExternal;
        $this->m_isAttachable = $isAttachable;
        $this->m_enableIpv6 = $enableIpv6;
    }


    public function getName() : string { return $this->m_name; }


    public function toArray(): array
    {
        $networkOptions = array();

        if ($this->m_driver !== null)
        {
            $networkOptions['driver'] = $this->m_driver;
        }

        if ($this->m_enableIpv6 !== null)
        {
            $networkOptions['enable_ipv6'] = $this->m_enableIpv6;
        }

        if ($this->m_isAttachable !== null)
        {
            $networkOptions['attachable'] = $this->m_isAttachable;
        }



        $arrayForm = array(
            $this->m_name => $networkOptions
        );
    }

}

