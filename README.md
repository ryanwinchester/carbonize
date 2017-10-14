# Carbonize

 [![Packagist](https://img.shields.io/packagist/l/ryanwinchester/carbonize.svg)](https://packagist.org/packages/ryanwinchester/carbonize)
 [![Packagist](https://img.shields.io/packagist/v/ryanwinchester/carbonize.svg)](https://packagist.org/packages/ryanwinchester/carbonize)
 [![Build Status](https://travis-ci.org/ryanwinchester/carbonize.svg?branch=master)](https://travis-ci.org/ryanwinchester/carbonize)
 [![Maintainability](https://api.codeclimate.com/v1/badges/6d9cea21fa5324d48cca/maintainability)](https://codeclimate.com/github/ryanwinchester/carbonize/maintainability)
 [![Test Coverage](https://api.codeclimate.com/v1/badges/6d9cea21fa5324d48cca/test_coverage)](https://codeclimate.com/github/ryanwinchester/carbonize/test_coverage)
 [![codecov](https://codecov.io/gh/ryanwinchester/carbonize/branch/master/graph/badge.svg)](https://codecov.io/gh/ryanwinchester/carbonize)


[Carbon](https://github.com/briannesbitt/Carbon) helper for creating new instances of Carbon from other Carbon objects,
DateTime|Immutable objects, date strings, timestamps, or null (for `now`).

## Install

```
composer require ryanwinchester/carbonize
```

## Usage

```php
$carbon = new Carbon();
$dt = new DateTime();
$dtImmutable = new DateTimeImmutable();

carbonize() == Carbon::now("UTC");

carbonize($carbon) == $carbon->copy();

carbonize($dt) == Carbon::instance($dt);

carbonize($dtImmutable) == Carbon::instance(new DateTime($dtImmutable->format(DateTime::ATOM)));

carbonize(1507957785) == Carbon::createFromTimestamp(1507957785, "UTC");

carbonize("1507957785") == Carbon::createFromTimestamp(1507957785, "UTC");

carbonize("2017-01-01") == Carbon::parse("2017-01-01", "UTC");

carbonize("1975-12-25T14:15:16-0500") == Carbon::parse("1975-12-25T14:15:16-0500", "UTC");

carbonize("3 months ago") == Carbon::parse("3 months ago", "UTC");
```

## License

MIT

## Credits

- **Carbon** (https://github.com/briannesbitt/Carbon)

## Notes

Although Carbon is decent, use [Chronos](https://github.com/cakephp/chronos) if you can.
https://github.com/cakephp/chronos

Immutability FTW ᕙ(⇀‸↼‶)ᕗ
