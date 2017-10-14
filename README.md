# Carbonize

Carbon helper for creating new instances of Carbon

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
