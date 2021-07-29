<?php

/*
 * Configure the rollback configuration. Added in 3.7.
 * https://docs.docker.com/compose/compose-file/compose-file-v3/#rollback_config
 */

namespace Programster\DockerCompose;


class RolloutConfig implements InterfaceArrayable
{
    private ?int $m_parallelism;
    private ?TimePeriod $m_delay;
    private ?FailureAction $m_failureAction;
    private ?TimePeriod $m_monitor;
    private float $m_maxFailureRatio;
    private ?RollbackOrder $m_order;


    /**
     *
     * @param int|null $parallelism - The number of containers to rollback at a time. If set to 0, all containers
     * rollback simultaneously.
     * @param TimePeriod|null $delay - The time to wait between each container group’s rollback (default 0s).
     * @param FailureAction|null $failureAction - What to do if a rollback fails. One of continue or pause (default pause)
     * @param TimePeriod|null $monitor - Duration after each task update to monitor for failure (default 5s)
     * @param float|null $maxFailureRatio - Failure rate to tolerate during a rollback (default 0).
     * @param RollbackOrder|null $order - Order of operations during rollbacks. One of stop-first (old task is stopped
     * before starting new one), or start-first (new task is started first, and the running tasks briefly overlap)
     * (default stop-first)
     */
    public function __construct(
        ?int $parallelism,
        ?TimePeriod $delay,
        ?FailureAction $failureAction,
        ?TimePeriod $monitor,
        ?float $maxFailureRatio,
        ?RollbackOrder $order
    )
    {
        $this->m_delay = $delay;
        $this->m_parallelism = $parallelism;
        $this->m_failureAction = $failureAction;
        $this->m_monitor = $monitor;
        $this->m_maxFailureRatio = $maxFailureRatio;
        $this->m_order = $order;
    }


    public function getRequiredComposeVersion() : float { return 3.7; }


    public function toArray(): array
    {
        $arrayForm = array();

        if ($this->m_parallelism !== null)
        {
            $arrayForm['parallelism'] = $this->m_parallelism;
        }

        if ($this->m_delay !== null)
        {
            $arrayForm['delay'] = $this->m_delay;
        }

        if ($this->m_failureAction !== null)
        {
            $arrayForm['failure_action'] = $this->m_failureAction;
        }

        if ($this->m_monitor !== null)
        {
            $arrayForm['monitor'] = $this->m_monitor;
        }

        if ($this->m_maxFailureRatio !== null)
        {
            $arrayForm['max_failure_ratio'] = $this->m_maxFailureRatio;
        }

        if ($this->m_order !== null)
        {
            $arrayForm['order'] = $this->m_order;
        }

        return $arrayForm;
    }
}
