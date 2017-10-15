<?php

use Carbon\Carbon;

if (! function_exists('carbonize')) {
    /**
     * @param mixed $datetime
     * @param string|null $tz
     * @return Carbon
     * @throws InvalidArgumentException
     */
    function carbonize($datetime = null, $tz = null)
    {
        switch (true) {
            case is_null($datetime):
                return new Carbon(null, $tz);
            case $datetime instanceof Carbon:
                $dt = clone $datetime;
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            case $datetime instanceof DateTime:
                $dt = Carbon::instance($datetime);
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            case $datetime instanceof DateTimeImmutable:
                $dt = new Carbon($datetime->format('Y-m-d H:i:s.u'), $datetime->getTimezone());
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            case is_numeric($datetime) && (string) (int) $datetime === (string) $datetime:
                return Carbon::createFromTimestamp((int) $datetime, $tz);
            case is_string($datetime) && strtotime($datetime) !== false:
                $dt = new Carbon($datetime, $tz);
                return is_null($tz) ? $dt : $dt->setTimezone($tz);
            default:
                throw new InvalidArgumentException(
                    "That is not a date time of any sort that I can deal with"
                );
        }
    }
}

if (! function_exists('carbon')) {
    /**
     * @param mixed $datetime
     * @param string|null $tz
     * @return Carbon
     * @throws InvalidArgumentException
     */
    function carbon($datetime = null, $tz = null)
    {
        return carbonize($datetime, $tz);
    }
}
