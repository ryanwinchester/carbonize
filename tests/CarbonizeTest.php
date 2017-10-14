<?php

namespace Carbonize\Tests;

use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;
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

    function test_carbonize_throws()
    {
        $this->expectException(\TypeError::class);

        carbonize("the quick brown fox");
    }
}
