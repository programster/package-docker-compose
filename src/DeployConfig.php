<?php


namespace Programster\DockerCompose;


final class DeployConfig implements \JsonSerializable, InterfaceArrayable
{
    private ?ResourceConfig $m_resourceConfig;
    private ?DeploymentMode $m_deploymentMode;
    private ?RolloutConfig $m_updateConfig;
    private ?RolloutConfig $m_rollbackConfig;
    private ?RestartPolicy $m_restartPolicy;
    private ?PlacementConfig $m_placementConfig;


    public function __construct(
        ?RestartPolicy $restartPolicy = null,
        ?DeploymentMode $mode = null,
        ?ResourceConfig $resourceConfig = null,
        ?RolloutConfig $updateConfig  = null,
        ?RolloutConfig $rollbackConfig = null,
        ?PlacementConfig $placement = null
    )
    {
        $this->m_restartPolicy = $restartPolicy;
        $this->m_deploymentMode = $deploymentMode;
        $this->m_resourceConfig = $resourceConfig;
        $this->m_updateConfig = $updateConfig;
        $this->m_rollbackConfig = $rollbackConfig;
        $this->m_placementConfig = $placement;
    }


    public function toArray(): array
    {
        $arrayForm = [];

        if ($this->m_restartPolicy !== null)
        {
            $arrayForm['restart_policy'] = $this->m_restartPolicy->toArray();
        }

        if ($this->m_resourceConfig !== null)
        {
            $arrayForm['resources'] = $this->m_resourceConfig->toArray();
        }

        if ($this->m_deploymentMode !== null)
        {
            $arrayForm['mode'] = $this->m_deploymentMode->toArray();
        }

        if ($this->m_updateConfig !== null)
        {
            $arrayForm['update_config'] = $this->m_updateConfig->toArray();
        }

        if ($this->m_rollbackConfig !== null)
        {
            $arrayForm['rollback_config'] = $this->m_rollbackConfig->toArray();
        }

        if ($this->m_placement !== null)
        {
            $arrayForm['placement'] = $this->m_placementConfig->toArray();
        }

        if ($this->m_deploymentMode !== null)
        {
            if ($this->m_deploymentMode->getMaxReplicasPerNode() !== null)
            {
                if (!isset($arrayForm['placement']))
                {
                    $arrayForm['placement'] = array();
                }

                $arrayForm['placement']['max_replicas_per_node'] = $this->m_deploymentMode->getMaxReplicasPerNode();
            }
        }

        return $arrayForm;
    }

    
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
