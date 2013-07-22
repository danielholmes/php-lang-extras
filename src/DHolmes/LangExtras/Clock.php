<?php

namespace DHolmes\LangExtras;

class Clock
{
    /** @var \DateTime */
    private $currentTime;

    /** @var \DateTimeZone */
    private $timezone;

    /** @param \DateTimeZone $timezone */
    public function __construct(\DateTimeZone $timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @param \DateTime|string $time
     */
    public function freezeTimeAt($time)
    {
        $description = $time;

        if ($time instanceof \DateTime)
        {
            $description = '@' . $time->getTimestamp();
        }

        $this->currentTime = $this->createTime($description);
    }

    public function unfreezeTime()
    {
        if (!$this->isFrozen())
        {
            throw new \RuntimeException('Clock isn\'t frozen');
        }
        $this->currentTime = null;
    }

    /** @return boolean */
    public function isFrozen()
    {
        return $this->currentTime !== null;
    }

    /**
     * @param \DateTimeZone $timezone
     * @return \DateTime
     */
    public function getCurrentTime(\DateTimeZone $timezone = null)
    {
        if (null === $timezone)
        {
            $timezone = $this->timezone;
        }

        if ($this->isFrozen())
        {
            $frozenDate = clone $this->currentTime;
            $frozenDate->setTimezone($timezone);

            return $frozenDate;
        }

        return $this->createTime('now');
    }

    /** @return \DateTime */
    public function getFrozenTime()
    {
        if ($this->isFrozen())
        {
            return clone $this->currentTime;
        }

        return null;
    }

    /**
     * @param \DateInterval $interval
     * @param \DateTimeZone $timezone
     * @return \DateTime
     */
    public function getCurrentTimeAddInterval(\DateInterval $interval, \DateTimeZone $timezone = null)
    {
        $current = $this->getCurrentTime($timezone);
        $current->add($interval);

        return $current;
    }

    /**
     * @param \DateInterval $interval
     * @param \DateTimeZone $timezone
     * @return \DateTime
     */
    public function getCurrentTimeSubInterval(\DateInterval $interval, \DateTimeZone $timezone = null)
    {
        $current = $this->getCurrentTime($timezone);
        $current->sub($interval);

        return $current;
    }

    /**
     * @param string $description
     * @return \DateTime
     */
    public function createTime($description = 'now')
    {
        return new \DateTime($description, $this->timezone);
    }

    /** @return \DateTime */
    public function createEndOfTime()
    {
        return $this->createTime('9999-12-31 23:59:59');
    }

    /** @var Clock */
    private static $globalClock;

    /** @return Clock */
    public static function getGlobal()
    {
        if (null === self::$globalClock) {
            $defaultTimezone = new \DateTimeZone('UTC');
            self::$globalClock = new Clock($defaultTimezone);
        }

        return self::$globalClock;
    }

    /** @param \DateTime|string $time */
    public static function freezeGlobalTimeAt($time)
    {
        static::getGlobal()->freezeTimeAt($time);
    }

    /**
     * @param string $description
     * @return \DateTime
     */
    public static function createGlobalTime($description = 'now')
    {
        return static::getGlobal()->createTime($description);
    }

    /** @return \DateTime */
    public static function createGlobalEndOfTime()
    {
        return static::getGlobal()->createEndOfTime();
    }

    /**
     * @param \DateInterval $interval
     * @param \DateTimeZone $timezone
     * @return \DateTime
     */
    public static function getGlobalCurrentTimeAddInterval(\DateInterval $interval, \DateTimeZone $timezone = null)
    {
        return static::getGlobal()->getCurrentTimeAddInterval($interval, $timezone);
    }

    /** @return \DateTime */
    public static function getGlobalFrozenTime()
    {
        return static::getGlobal()->getFrozenTime();
    }

    /**
     * @param \DateInterval $interval
     * @param \DateTimeZone $timezone
     * @return \DateTime
     */
    public static function getGlobalCurrentTimeSubInterval(\DateInterval $interval, \DateTimeZone $timezone = null)
    {
        return static::getGlobal()->getCurrentTimeSubInterval($interval, $timezone);
    }

    /** @return \DateTime */
    public static function getGlobalCurrentTime()
    {
        return self::getGlobal()->getCurrentTime();
    }

    public static function unfreezeGlobalTime()
    {
        static::getGlobal()->unfreezeTime();
    }
}
