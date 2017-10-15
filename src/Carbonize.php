<?php

namespace Carbonize;

use Carbon\Carbon;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;

class Carbonize
{
    /**
     * Convert some sort of datetime object, string, or timestamp into a new
     * instance of Carbon.
     *
     * @param mixed $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     * @throws InvalidArgumentException
     */
    public static function toCarbon($datetime = null, $timezone = null)
    {
        $carbonize = new static;

        switch (true) {
            case is_null($datetime):
                return $carbonize->now($timezone);
            case $datetime instanceof Carbon:
                return $carbonize->fromCarbon($datetime, $timezone);
            case $datetime instanceof DateTimeInterface:
                return $carbonize->fromDateTime($datetime, $timezone);
            case $carbonize->isTimestamp($datetime):
                return $carbonize->fromTimestamp($datetime, $timezone);
            case $carbonize->isDatetimeString($datetime):
                return $carbonize->fromDatetimeString($datetime, $timezone);
            default:
                throw new InvalidArgumentException("Can't carbonize this");
        }
    }

    /**
     * Check if the variable might be a timestamp.
     *
     * @param mixed $datetime
     * @return bool
     */
    public function isTimestamp($datetime)
    {
        return is_numeric($datetime) && (string) (int) $datetime === (string) $datetime;
    }

    /**
     * Check if the variable can be parsed as a datetime string.
     *
     * @param mixed $datetime
     * @return bool
     */
    public function isDatetimeString($datetime)
    {
        return is_string($datetime) && strtotime($datetime) !== false;
    }

    /**
     * Get an instance of Carbon for the current time.
     *
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    public function now($timezone)
    {
        return new Carbon(null, $timezone);
    }

    /**
     * Get a new Carbon instance from an existing one.
     *
     * @param Carbon $carbon
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    public function fromCarbon(Carbon $carbon, $timezone)
    {
        return $this->withTimezone(clone $carbon, $timezone);
    }

    /**
     * Get a new Carbon instance from a DateTimeInterface instance.
     *
     * @param DateTimeInterface $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    public function fromDateTime(DateTimeInterface $datetime, $timezone)
    {
        return $this->withTimezone(
            new Carbon(
                $datetime->format('Y-m-d H:i:s.u'),
                $datetime->getTimezone()
            ),
            $timezone
        );
    }

    /**
     * Get a new Carbon instance from an integer or string timestamp.
     *
     * @param int|string $timestamp
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    public function fromTimestamp($timestamp, $timezone)
    {
        return (new Carbon(null, $timezone))->setTimestamp($timestamp);
    }

    /**
     * Get a new Carbon instance from a datetime string.
     *
     * @param string $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    public function fromDatetimeString($datetime, $timezone)
    {
        return $this->withTimezone(
            new Carbon($datetime, $timezone),
            $timezone
        );
    }

    /**
     * Set the timezone if one was supplied.
     *
     * @param Carbon $carbon
     * @param DateTimeZone|string|null $timezone
     * @return Carbon
     */
    private function withTimezone(Carbon $carbon, $timezone)
    {
        return is_null($timezone) ? $carbon : $carbon->setTimezone($timezone);
    }
}
