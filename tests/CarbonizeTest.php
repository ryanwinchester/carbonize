<?php

namespace Carbonize\Tests;

use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Generator;
use PHPUnit\Framework\TestCase;

final class CarbonizeTest extends TestCase
{
    function test_instanceof()
    {
        $carbon = new Carbon();

        $carbon0 = carbonize($carbon);
        $carbon1 = carbonize(new DateTimeImmutable());
        $carbon2 = carbonize(new DateTime());
        $carbon3 = carbonize();
        $carbon4 = carbonize(1507957785);
        $carbon5 = carbonize("2017-01-01");
        $carbon6 = carbonize("1975-12-25T14:15:16-0500");
        $carbon7 = carbonize("1975-12-25T14:15:16-0500");

        $this->assertInstanceOf(Carbon::class, $carbon0);
        $this->assertInstanceOf(Carbon::class, $carbon1);
        $this->assertInstanceOf(Carbon::class, $carbon2);
        $this->assertInstanceOf(Carbon::class, $carbon3);
        $this->assertInstanceOf(Carbon::class, $carbon4);
        $this->assertInstanceOf(Carbon::class, $carbon5);
        $this->assertInstanceOf(Carbon::class, $carbon6);
        $this->assertInstanceOf(Carbon::class, $carbon7);

        $this->assertFalse($carbon0 === $carbon);
    }

    function test_carbon()
    {
        $this->assertEquals(
            carbonize("2001-12-13 12:00:00", "America/Vancouver"),
            carbon("2001-12-13 12:00:00", "America/Vancouver")
        );
    }

    function test_carbonize()
    {
        $carbon = new Carbon();
        $dt = new DateTime();
        $dtImmutable = new DateTimeImmutable();

        $this->assertTrue(carbonize($carbon) == $carbon->copy());
        $this->assertTrue(carbonize($dt) == Carbon::instance($dt));
        $this->assertTrue(carbonize($dtImmutable) == Carbon::instance(new DateTime($dtImmutable->format(DateTime::ATOM))));
        $this->assertTrue(carbonize(1507957785) == Carbon::createFromTimestamp(1507957785, "UTC"));
        $this->assertTrue(carbonize("1507957785") == Carbon::createFromTimestamp(1507957785, "UTC"));
        $this->assertTrue(carbonize("2017-01-01") == Carbon::parse("2017-01-01", "UTC"));
        $this->assertTrue(carbonize("1975-12-25T14:15:16-0500") == Carbon::parse("1975-12-25T14:15:16-0500", "UTC"));
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_with_timezone($timezone)
    {
        $carbon = new Carbon(null, $timezone);
        $dtTimezone = new DateTimeZone($timezone);
        $dt = new DateTime("now", $dtTimezone);
        $dtImmutable = new DateTimeImmutable("now", $dtTimezone);

        $this->assert_carbon_with_timezone(carbonize($carbon), $carbon->copy());
        $this->assert_carbon_with_timezone(carbonize($dt), Carbon::instance($dt));
        $this->assert_carbon_with_timezone(carbonize($dtImmutable), Carbon::instance(new DateTime($dtImmutable->format(DateTime::ATOM))));
        $this->assert_carbon_with_timezone(carbonize(1507957785, $timezone), Carbon::createFromTimestamp(1507957785, $timezone));
        $this->assert_carbon_with_timezone(carbonize("1507957785", $timezone), Carbon::createFromTimestamp(1507957785, $timezone));
        $this->assert_carbon_with_timezone(carbonize("2017-01-01", $timezone), Carbon::parse("2017-01-01", $timezone));
        $this->assert_carbon_with_timezone(carbonize("1975-12-25T14:15:16-0500", $timezone), Carbon::parse("1975-12-25T14:15:16-0500", $timezone));
    }

    /**
     * @param Carbon $carbon1
     * @param Carbon $carbon2
     */
    function assert_carbon_with_timezone($carbon1, $carbon2)
    {
        $this->assertTrue($carbon1 == $carbon2);
        $this->assertTrue($carbon1->getTimezone()->getName() == $carbon2->getTimezone()->getName());
    }

    /**
     * @return Generator
     */
    function timezone_provider()
    {
        yield ["UTC"];
        yield ["UCT"];
        yield ["Africa/Cairo"];
        yield ["America/Detroit"];
        yield ["Antarctica/Vostok"];
        yield ["Arctic/Longyearbyen"];
        yield ["Asia/Tokyo"];
        yield ["Atlantic/Reykjavik"];
        yield ["Australia/Melbourne"];
        yield ["Europe/Vilnius"];
        yield ["Indian/Maldives"];
        yield ["Pacific/Galapagos"];
    }

    /**
     * @dataProvider invalid_time_provider
     * @expectedException \InvalidArgumentException
     * @param mixed $time
     */
    function test_carbonize_invalid_time($time)
    {
        carbonize($time);
    }

    /**
     * @return Generator
     */
    function invalid_time_provider()
    {
        yield ["the quick brown fox"];
        yield [true];
        yield [new \StdClass()];
        yield [[]];
    }
}
