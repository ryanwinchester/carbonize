# Carbonize

 [![Packagist](https://img.shields.io/packagist/l/ryanwinchester/carbonize.svg)](https://packagist.org/packages/ryanwinchester/carbonize)
 [![Build Status](https://travis-ci.org/ryanwinchester/carbonize.svg?branch=master)](https://travis-ci.org/ryanwinchester/carbonize)
 [![Codecov](https://img.shields.io/codecov/c/github/ryanwinchester/carbonize.svg)](https://codecov.io/gh/ryanwinchester/carbonize)
 [![Maintainability](https://api.codeclimate.com/v1/badges/6d9cea21fa5324d48cca/maintainability)](https://codeclimate.com/github/ryanwinchester/carbonize/maintainability)


[Carbon](https://github.com/briannesbitt/Carbon) helper for creating new instances of Carbon from other Carbon objects,
DateTime|Immutable objects, date strings, timestamps, or null (for `now`).

Sometimes we have to work on projects that already exist or are underway, that are full of magic and inconsistent date formats.
Is this going to be a timestamp? a date string? a Carbon instance? Does it even matter as long as it's a datetime of some sort? ¯\\\_(ツ)\_/¯

```php
    public function doMyThing($datetime)
    {
        // Whatever it was, it is _now_ a NEW carbon instance
        $datetime = carbonize($datetime);

        // do stuff with your carbon instance
    }
```

You can use it as either `carbonize()`, `carbon()`, or `Carbonize\Carbonize::toCarbon()`.

## Install

```
composer require ryanwinchester/carbonize
```

## What it does

```php
carbonize() == Carbon::now("UTC");

$carbon = new Carbon();
carbonize($carbon) == $carbon->copy();

$dt = new DateTime();
carbonize($dt) == Carbon::instance($dt);

$dtImmutable = new DateTimeImmutable();
carbonize($dtImmutable) == Carbon::instance(new DateTime($dtImmutable->format(DateTime::ATOM)));

carbonize(1507957785) == Carbon::createFromTimestamp(1507957785, "UTC");

carbonize("1507957785") == Carbon::createFromTimestamp(1507957785, "UTC");

carbonize("2017-01-01 12:04:01") == Carbon::parse("2017-01-01 12:04:01", "UTC");

carbonize("3 months ago") == Carbon::parse("3 months ago", "UTC");
```

## License

MIT

## Credits

- **Carbon** (https://github.com/briannesbitt/Carbon)

## Notes

- Please use Carbon 1.21 (not 1.22) until timezones are fixed. (https://github.com/briannesbitt/Carbon/issues/863)
- Although Carbon is decent, use [Chronos](https://github.com/cakephp/chronos) if you can. (https://github.com/cakephp/chronos)

<3 Chronos, Immutability FTW ᕙ(⇀‸↼‶)ᕗ
