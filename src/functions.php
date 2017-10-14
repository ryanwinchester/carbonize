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
            case is_numeric($time) && (string) (int) $time === (string) $time:
                return Carbon::createFromTimestamp((int) $time, $tz);
            case is_string($time) && strtotime($time) !== false:
                return Carbon::parse($time, $tz);
            default:
                throw new InvalidArgumentException("I don't know what to do with this.");
        }
    }
}
