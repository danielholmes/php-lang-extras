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
        if (static::isFrozen())
        {
            $current = clone self::$frozenTime;
        }
        else
        {
            $current = new \DateTime();
        }
        return $current;
    }

    /** @return boolean */
    public static function isFrozen()
    {
        return self::$frozenTime !== null;
    }

    public static function unfreezeTime()
    {
        if (!static::isFrozen())
        {
            throw new \LogicException('Time isn\'t frozen');
        }
        self::$frozenTime = null;
    }

    /** @param \DateTime $time */
    public static function freezeTimeAt(\DateTime $time)
    {
        self::$frozenTime = clone $time;
    }
}
