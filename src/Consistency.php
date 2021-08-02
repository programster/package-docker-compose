<?php

/*
 * Create a consistency mode.
 * Note: this only has an effect on Mac OS.
 * https://stackoverflow.com/questions/43844639/how-do-i-add-cached-or-delegated-into-a-docker-compose-yml-volumes-list
 */

namespace Programster\DockerCompose;

class Consistency
{
    private string $m_consistency;

    private function __construct(string $consistency)
    {
        $this->m_consistency = $consistency;
    }


    /**
     * Creates the default consistency, which is the same as "consistent" whereby both the container and host actively
     * change the data.
     * @return Consistency
     */
    public static function createDefault() : Consistency { return new Consistency("default"); }


    /**
     * Effectively the same as "default". Both the container and host actively
     * change the data.
     * @return Consistency
     */
    public static function createConsistent() : Consistency { return new Consistency("consistent"); }


    /**
     * The docker container performs changes, host is in read only mode.
     * @return Consistency
     */
    public static function createDelegated() : Consistency { return new Consistency("delegated"); }


    /**
     * Host performs changes, the container is in read only mode.
     * @return Consistency
     */
    public static function createCached() : Consistency { return new Consistency("cached"); }
}
