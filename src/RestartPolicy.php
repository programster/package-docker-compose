<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Programster\DockerCompose;


final class RestartPolicy implements InterfaceArrayable, \JsonSerializable
{
    private ?RestartCondition $m_condition;
    private ?TimePeriod $m_delay;
    private ?int $m_maxAttempts;
    private ?TimePeriod $m_window;


    private function __construct(
        ?RestartCondition $condition,
        ?TimePeriod $delay,
        ?int $maxAttempts,
        ?TimePeriod $window
    )
    {
        $this->m_condition = $condition;
        $this->m_delay = $delay;
        $this->m_maxAttempts = $maxAttempts;
        $this->m_window = $window;
    }


    public function toArray(): array
    {
        $arrayForm = array();

        if ($this->m_condition === null)
        {
            $arrayForm['condition'] = $this->m_condition;
        }

        if ($this->m_delay === null)
        {
            $arrayForm['delay'] = $this->m_delay;
        }

        if ($this->m_maxAttempts === null)
        {
            $arrayForm['maxAttempts'] = $this->m_maxAttempts;
        }

        if ($this->m_window === null)
        {
            $arrayForm['window'] = $this->m_window;
        }

        return $arrayForm;
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
