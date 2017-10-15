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

    /**
     * @dataProvider invalid_time_provider
     * @expectedException \InvalidArgumentException
     * @param mixed $time
     */
    function test_carbonize_invalid_time($time)
    {
        carbonize($time);
    }

    function test_carbonize()
    {
        $carbon = new Carbon();
        $dt = new DateTime();
        $dtImmutable = new DateTimeImmutable();

        $this->assertTrue(carbonize($carbon) == $carbon->copy());
        $this->assertTrue(carbonize($dt) == Carbon::instance($dt));
        $this->assertTrue(carbonize($dtImmutable) == new Carbon($dtImmutable->format('Y-m-d H:i:s.u'), $dtImmutable->getTimezone()));
        $this->assertTrue(carbonize(1507957785) == Carbon::createFromTimestamp(1507957785, "UTC"));
        $this->assertTrue(carbonize("1507957785") == Carbon::createFromTimestamp(1507957785, "UTC"));
        $this->assertTrue(carbonize("2017-01-01") == Carbon::parse("2017-01-01", "UTC"));
        $this->assertTrue(carbonize("1975-12-25T14:15:16-0500") == Carbon::parse("1975-12-25T14:15:16-0500", "UTC"));
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_carbon_with_timezone($timezone)
    {
        $carbon = new Carbon(null, $timezone);

        $carbon1 = carbonize($carbon);
        $carbon2 = $carbon->copy();

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_with_timezone($timezone)
    {
        $dt = new DateTime("now", new DateTimeZone($timezone));

        $carbon1 = carbonize($dt);
        $carbon2 = Carbon::instance($dt);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_immutable_with_timezone($timezone)
    {
        $dtImmutable = new DateTimeImmutable("now", new DateTimeZone($timezone));

        $carbon1 = carbonize($dtImmutable);
        $carbon2 = new Carbon($dtImmutable->format('Y-m-d H:i:s.u'), $dtImmutable->getTimezone());

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_timestamp_with_timezone($timezone)
    {
        $carbon1 = carbonize(1507957785, $timezone);
        $carbon2 = Carbon::createFromTimestamp(1507957785, $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_timestamp_string_with_timezone($timezone)
    {
        $carbon1 = carbonize("1507957785", $timezone);
        $carbon2 = Carbon::createFromTimestamp(1507957785, $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_strings_with_timezone($timezone)
    {
        $carbon1 = carbonize("2017-01-01", $timezone);
        $carbon2 = Carbon::parse("2017-01-01", $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());

        $carbon1 = carbonize("1975-12-25T14:15:16-0500", $timezone);
        $carbon2 = Carbon::parse("1975-12-25T14:15:16-0500")->setTimezone($timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    // Converting timezones

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_carbon_with_timezone_setting($timezone)
    {
        $carbon = new Carbon(null, $timezone);

        $carbon1 = carbonize($carbon, $timezone);
        $carbon2 = $carbon->copy()->setTimezone($timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_with_timezone_setting($timezone)
    {
        $dt = new DateTime("now", new DateTimeZone($timezone));

        $carbon1 = carbonize($dt, $timezone);
        $carbon2 = Carbon::instance($dt)->setTimezone($timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_immutable_with_timezone_setting($timezone)
    {
        $dtImmutable = new DateTimeImmutable("now", new DateTimeZone($timezone));

        $carbon1 = carbonize($dtImmutable, $timezone);
        $carbon2 = (new Carbon($dtImmutable->format('Y-m-d H:i:s.u'), $dtImmutable->getTimezone()))
            ->setTimezone($timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_timestamp_with_timezone_setting($timezone)
    {
        $carbon1 = carbonize(1507957785, $timezone);
        $carbon2 = Carbon::createFromTimestamp(1507957785, $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_timestamp_string_with_timezone_setting($timezone)
    {
        $carbon1 = carbonize("1507957785", $timezone);
        $carbon2 = Carbon::createFromTimestamp(1507957785, $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
    }

    /**
     * @dataProvider timezone_provider
     * @param string $timezone
     */
    function test_carbonize_datetime_strings_with_timezone_setting($timezone)
    {
        $carbon1 = carbonize("2017-01-01", $timezone);
        $carbon2 = Carbon::parse("2017-01-01", $timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());

        $carbon1 = carbonize("1975-12-25T14:15:16-0500", $timezone);
        $carbon2 = Carbon::parse("1975-12-25T14:15:16-0500")->setTimezone($timezone);

        $this->assertEquals($carbon1->toIso8601String(), $carbon2->toIso8601String());
        $this->assertEquals($carbon1->getTimezone()->getName(), $carbon2->getTimezone()->getName());
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
