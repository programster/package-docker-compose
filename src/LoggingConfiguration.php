<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Programster\DockerCompose;

class LoggingConfiguration implements \JsonSerializable, InterfaceArrayable
{
    private string $m_driver;
    private ?array $m_options;

    public function __construct(string $driver, NameValuePair ...$options)
    {
        $this->m_driver = $driver;
        $this->m_options = $options;
    }


    public function toArray(): array
    {
        $arrayForm = ['driver' => $this->m_driver];

        if ($this->m_options !== null && count($this->m_options) > 0)
        {
            $arrayForm['options'] = array();

            foreach ($this->m_options as $option)
            {
                $arrayForm['options'][] = (string)$option;
            }
        }

        return $arrayForm;
    }


    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}