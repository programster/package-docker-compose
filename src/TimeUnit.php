<?php

/*
 */

namespace Programster\DockerCompose;

class TimeUnit implements \Stringable
{
    private string $m_unit;


    private function __construct(string $unit)
    {
        $this->m_unit = $unit;
    }


    /**
     * Create nanosecond. This is 0.000000001 seconds (9 decimal places).
     * @return TimeUnit
     */
    public static function createNanosecond() : TimeUnit { return new TimeUnit("ns"); }

    /**
     * Create nanosecond. This is 0.000001 seconds. (6 decimal places).
     * @return TimeUnit
     */
    public static function createMicrosecond() : TimeUnit { return new TimeUnit("us"); }

    /**
     * Create microsecond. This is 0.001 seconds
     * @return TimeUnit
     */
    public static function createMillisecond() : TimeUnit { return new TimeUnit("ms"); }
    public static function createSecond() : TimeUnit { return new TimeUnit("s"); }
    public static function createMinute() : TimeUnit { return new TimeUnit("m"); }
    public static function createHour() : TimeUnit { return new TimeUnit("h"); }


    public function __toString()
    {
        return $this->m_unit;
    }
}