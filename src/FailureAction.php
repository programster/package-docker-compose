<?php

/*
 * A class to act as an enum to the possible failure actions in a rollback config.
 * https://docs.docker.com/compose/compose-file/compose-file-v3/#rollback_config
 */

namespace Programster\DockerCompose;

class FailureAction implements \Stringable
{
    private string $m_action;


    private function __construct(string $action)
    {
        $this->m_action = $action;
    }


    public static function createPause() : FailureAction { return new FailureAction("pause"); }
    public static function createContinue() : FailureAction { return new FailureAction("continue"); }


    public function __toString() { return $this->m_action; }
}
