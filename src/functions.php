<?php

use Carbon\Carbon;

if (! function_exists('carbonize')) {
    /**
     * @param mixed $time
     * @param string $tz
     * @return Carbon
     * @throws InvalidArgumentException
     */
    function carbonize($time = null, $tz = 'UTC')
    {
        switch (true) {
            case is_null($time):
                return Carbon::now($tz);
            case $time instanceof Carbon:
                return $time->copy();
            case $time instanceof DateTime:
                return Carbon::instance($time);
            case $time instanceof DateTimeImmutable:
                return Carbon::instance(new DateTime($time->format(DateTime::ATOM)));
            case is_timestamp($time):
                return Carbon::createFromTimestamp((int) $time, $tz);
            case is_datetime_string($time):
                return Carbon::parse($time, $tz);
            default:
                throw new InvalidArgumentException("I don't know what to do with this.");
        }
    }
}

if (! function_exists('is_datetime_string')) {
    /**
     * Check if it might be a datetime string.
     *
     * @param mixed $time
     * @return bool
     */
    function is_datetime_string($time)
    {
        return is_string($time) && strtotime($time) !== false;
    }
}

if (! function_exists('is_timestamp')) {
    /**
     * Check if it might be a valid timestamp.
     *
     * @param mixed $time
     * @return bool
     */
    function is_timestamp($time)
    {
        return is_numeric($time) && (string) (int) $time === (string) $time;
    }
}
