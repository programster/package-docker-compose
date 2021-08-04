<?php

/*
 * A build argument:
 * https://github.com/compose-spec/compose-spec/blob/master/build.md#args
 */


class BuildArgument implements Stringable
{
    private string $m_name;
    private string|float|int|null $m_value;


    /**
     * Create a build argument.
     * @param string $name - the name for the build argument/variable.
     * @param string|float|int|null $value - the value for the build argument. May be null, in which case the value must
     * be obtained through user interaction when building the docker image.
     */
    public function __construct(string $name, string|float|int|null $value)
    {
        $this->m_name = $name;
        $this->m_value = $value;
    }


    public function __toString()
    {
        return ($this->m_value !== null) ? "{$this->m_name}={$this->m_value}" : $this->m_name;
    }
}

