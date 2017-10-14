<?php

namespace Carbonize\Tests;

use PHPUnit\Framework\TestCase;

final class IsDateTimeStringTest extends TestCase
{
    function test_isDateTimeString_true()
    {
        $this->assertTrue(is_datetime_string('2017-01-01'));
        $this->assertTrue(is_datetime_string('1975-12-25T14:15:16-0500'));
        $this->assertTrue(is_datetime_string('Thu, 25 Dec 1975 14:15:16 -0500'));
        $this->assertTrue(is_datetime_string('3 months ago'));
        $this->assertTrue(is_datetime_string('now + 3 months'));
    }

    function test_isDateTimeString_false()
    {
        $this->assertFalse(is_datetime_string(1507957785));
        $this->assertFalse(is_datetime_string(null));
    }
}
