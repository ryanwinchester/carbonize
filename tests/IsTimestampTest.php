<?php

namespace Carbonize\Tests;

use PHPUnit\Framework\TestCase;

final class IsTimestampTest extends TestCase
{
    function test_isTimestamp_true()
    {
        $this->assertTrue(is_timestamp(1507957785));
        $this->assertTrue(is_timestamp(-1507957785));
        $this->assertTrue(is_timestamp('1507957785'));
    }

    function test_isTimestamp_false()
    {
        $this->assertFalse(is_timestamp(150795778.5));
        $this->assertFalse(is_timestamp('150795778.5'));
    }
}
