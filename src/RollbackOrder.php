<?php

/*
 * Configure the rollback configuration. Added in 3.7.
 * https://docs.docker.com/compose/compose-file/compose-file-v3/#rollback_config
 */

namespace Programster\DockerCompose;

final class RollbackOrder implements \Stringable
{
    private string $m_order;


    private function __construct(string $order)
    {
        $this->m_order = $order;
    }


    /**
     * Configure update/rollback so that the new task is started first, and the running tasks briefly overlap). This
     * is the default.
     * @return RollbackOrder
     */
    public static function createStopFirst() : RollbackOrder { return new RollbackOrder("stop-first"); }


    /**
     * Configure update/rollback so that the old task is stopped before starting new one
     * @return RollbackOrder
     */
    public static function createStartFirst() : RollbackOrder { return new RollbackOrder("start-first"); }


    public function __toString() { return $this->m_order; }
}