<?php

/*
 * The deployment mode configuration. Learn more at:
 * https://docs.docker.com/engine/swarm/how-swarm-mode-works/services/#replicated-and-global-services
 */

namespace Programster\DockerCompose;


class DeploymentMode implements InterfaceArrayable
{
    private string $m_mode;
    private ?int $m_replicas;
    private ?int $m_maxReplicasPerNode;


    private function __construct(string $mode, ?int $replicas, ?int $maxReplicasPerNode)
    {
        $this->m_replicas;
        $this->m_mode = $mode;
        $this->m_maxReplicasPerNode = $maxReplicasPerNode;
    }


    /**
     * Deploys the number of instances as specified by 'replicas' across the entire swarm. This is the default
     * with a default value for replicas of 1.
     * @return DeploymentMode
     */
    public static function createReplicated(int $replicas, ?int $maxReplicasPerNode) : DeploymentMode
    {
        return new DeploymentMode("replicated", $replicas, $maxReplicasPerNode);
    }


    /**
     * Deploys exactly one container per swarm node.
     * @return DeploymentMode
     */
    public static function createGlobal() : DeploymentMode { return new DeploymentMode("global", null); }


    public function toArray(): array
    {
        $arrayForm = array(
            'mode' => $this->m_mode
        );

        if ($this->m_replicas !== null)
        {
            $arrayForm['replicas'] = $this->m_replicas;
        }

        return $arrayForm;
    }


    public function getReplicas() : ?int { return $this->m_replicas; }
    public function getMode() : string { return $this->m_mode; }
    public function getMaxReplicasPerNode() : ?int { return $this->m_maxReplicasPerNode; }
}

