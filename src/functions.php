<?php

use Carbonize\Carbonize;

if (! function_exists('carbonize')) {
    /**
     * @param mixed $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Carbon\Carbon
     * @throws InvalidArgumentException
     */
    function carbonize($datetime = null, $timezone = null)
    {
        return Carbonize::toCarbon($datetime, $timezone);
    }
}

if (! function_exists('carbon')) {
    /**
     * @param mixed $datetime
     * @param DateTimeZone|string|null $timezone
     * @return Carbon\Carbon
     * @throws InvalidArgumentException
     */
    function carbon($datetime = null, $timezone = null)
    {
        return Carbonize::toCarbon($datetime, $timezone);
    }
}
