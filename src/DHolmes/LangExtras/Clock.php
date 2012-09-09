<?php

namespace DHolmes\LangExtras;

class Clock
{
    /** @var \DateTime */
    private static $frozenTime;

    /** @return \DateTime */
    public static function getCurrentTime()
    {
        $current = null;
        if (self::$frozenTime === null)
        {
            $current = new \DateTime();
        }
        else
        {
            $current = clone self::$frozenTime;
        }
        return $current;
    }

    /** @param \DateTime $time */
    public static function freezeTimeAt(\DateTime $time)
    {
        self::$frozenTime = clone $time;
    }
}
