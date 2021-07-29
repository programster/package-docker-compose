<?php

/*
 * https://docs.docker.com/compose/compose-file/compose-file-v3/#restart_policy
 */

namespace Programster\DockerCompose;

class RestartCondition implements \Stringable
{
    private string $m_condition;


    private function __construct(string $condition)
    {
        $this->m_condition = $condition;
    }


    /**
     * Restart when the container exits due to a failure in the foreground process.
     * @return RestartCondition
     */
    public static function createOnFailure() : RestartCondition { return new RestartCondition("on-failure"); }


    /**
     * Restart under no condition.
     * @return RestartCondition
     */
    public static function createNone() : RestartCondition { return new RestartCondition("none"); }

    /**
     * Restart under any condition. This is the default.
     * @return RestartCondition
     */
    public static function createAny() : RestartCondition { return new RestartCondition("any"); }


    public function __toString()
    {
        return $this->m_condition;
    }
}