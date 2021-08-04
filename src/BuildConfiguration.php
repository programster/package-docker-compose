<?php

/*
 * A class to represent a service build configuration.
 * https://github.com/compose-spec/compose-spec/blob/master/build.md
 */

namespace Programster\DockerCompose;


class BuildConfiguration implements \JsonSerializable
{
    private string $m_context;
    private ?string $m_dockerfile;
    private ?BuildArgumentCollection $m_args;
    private ?array $m_cacheFrom;
    private ?ExtraHostCollection $m_extraHosts;
    private ?string $m_isolation;
    private ?LabelCollection $m_labels;
    private ?string $m_network;
    private ?int $m_shmSize;
    private ?string $m_target;


    /**
     * Create a build configuration to have docker-compose build an image for this service.
     *
     * @param string $context - defines either a path to a directory containing a Dockerfile, or a URL to a git
     * repository. When the value supplied is a relative path, it MUST be interpreted as relative to the location of
     * the Compose file. Compose implementations MUST warn user about absolute path used to define build context as
     * those prevent Compose file from being portable.
     *
     * @param string|null $dockerfile - the relative path to the Dockerfile from the build context.
     * https://github.com/compose-spec/compose-spec/blob/master/build.md#dockerfile
     *
     * @param BuildArgumentCollection|null $args - A collection of build arguments.
     *
     * @param array|null $cacheFrom - defines a list of images that the image builder should use for cache resolution.
     * E.g. ["alpine:latest", "corp/web_app:3.14"]
     * https://github.com/compose-spec/compose-spec/blob/master/build.md#cache_from
     *
     * @param ExtraHostCollection|null $extraHosts - optionally set host:ipaddress records. These will be put into the
     * containers /etc/hosts file. https://github.com/compose-spec/compose-spec/blob/master/build.md#extra_hosts
     *
     * @param string|null $isolation - specifies a container’s isolation technology. Supported values are
     * platform-specific. https://github.com/compose-spec/compose-spec/blob/master/spec.md#isolation
     *
     * @param LabelCollection|null $labels - Add metadata to a resulting image using docker object labels:
     * https://docs.docker.com/config/labels-custom-metadata/
     * https://github.com/compose-spec/compose-spec/blob/master/spec.md#labels
     * https://docs.docker.com/compose/compose-file/compose-file-v3/#labels
     *
     * @param string|null $network - Set the network containers connect to for the RUN instructions during build.
     * Added in version 3.4 file format
     * https://docs.docker.com/compose/compose-file/compose-file-v3/#network
     *
     * @param int|null $shmSize - Set the size (in bytes) of the /dev/shm partition for this build’s containers.
     * .https://docs.docker.com/compose/compose-file/compose-file-v3/#shm_size
     *
     * @param string|null - Build the specified stage as defined inside the Dockerfile. See the multi-stage build docs
     * for details (https://docs.docker.com/develop/develop-images/multistage-build/)
     */
    public function __construct(
        string $context = ".",
        ?string $dockerfile = null,
        ?BuildArgumentCollection $args = null,
        ?array $cacheFrom = null,
        ?ExtraHostCollection $extraHosts = null,
        ?string $isolation = null,
        ?NameValuePairCollection $labels = null,
        ?string $network = null,
        ?int $shmSize = null,
        ?string $target = null,
    )
    {
        $this->m_context = $context;
        $this->m_dockerfile = $dockerfile;
        $this->m_args = $args;
        $this->m_cacheFrom = $cacheFrom;
        $this->m_extraHosts = $extraHosts;
        $this->m_isolation = $isolation;
        $this->m_labels = $labels;
        $this->m_network = $network;
        $this->m_shmSize = $shmSize;
        $this->m_target = $target;
    }


    public function jsonSerialize(): mixed
    {
        $arrayForm = ['context' => $this->m_context];

        if ($this->m_dockerfile !== null) { $arrayForm['dockerfile'] = $this->m_dockerfile; }
        if ($this->m_args !== null) { $arrayForm['args'] = $this->m_args; }
        if ($this->m_cacheFrom !== null) { $arrayForm['cache_from'] = $this->m_cacheFrom; }
        if ($this->m_extraHosts !== null) { $arrayForm['extra_hosts'] = $this->m_extraHosts; }
        if ($this->m_isolation !== null) { $arrayForm['isolation'] = $this->m_isolation; }
        if ($this->m_labels !== null) { $arrayForm['labels'] = $this->m_labels; }
        if ($this->m_network !== null) { $arrayForm['network'] = $this->m_network; }
        if ($this->m_shmSize !== null) { $arrayForm['shm_size'] = $this->m_shmSize; }
        if ($this->m_target !== null) { $arrayForm['target'] = $this->m_target; }

        return $arrayForm;
    }
}
