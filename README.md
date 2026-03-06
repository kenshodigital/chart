# kenshō chart

[![Tests][qYMN]][9Jne]

Calculates [technical indicators][8LYS] in PHP.

[qYMN]: https://github.com/kenshodigital/chart/actions/workflows/tests.yml/badge.svg
[9Jne]: https://github.com/kenshodigital/chart/actions/workflows/tests.yml
[8LYS]: https://en.wikipedia.org/wiki/Technical_indicator

## General

- [PHP 8.2][yNT3], [PHP 8.3][886u], [PHP 8.4][wCzQ], [PHP 8.5][wCzQ]
- Minimal dependencies.
- Uses [brick/math][R3EG] for arbitrary precision numbers.
- Avoids redundant calculations and keeps the overall complexity low.
- Unit- and integration tested against [other libraries][QFtS] and [real-world data][fcZM].

[yNT3]: https://www.php.net/releases/8.2/en.php
[886u]: https://www.php.net/releases/8.3/en.php
[wCzQ]: https://www.php.net/releases/8.4/en.php
[sWm8]: https://www.php.net/releases/8.5/en.php
[R3EG]: https://github.com/brick/math
[QFtS]: https://github.com/bennycode/trading-signals
[fcZM]: https://www.alphavantage.co

### Audience

The library assumes a basic understanding of [technical analysis][7RzT] and how to use these technical indicators.

[7RzT]: https://en.wikipedia.org/wiki/Technical_analysis

## Installation

```shell
composer require kenshodigital/chart ^2.2
```

## Usage

- [Prepare chart][LgjB]
- [Calculate individual indicators][BXC6]
- [Calculate all indicators][jJTZ]

[LgjB]: #prepare-chart
[BXC6]: #calculate-individual-indicators
[jJTZ]: #calculate-all-indicators

### Prepare chart

```php
<?php declare(strict_types=1);

use Kensho\Chart\Chart\ChartFactory;

$chart = ChartFactory::bootstrap([
    '2023-01-25' => [
        'open'   => '140.8900',
        'high'   => '142.4300',
        'low'    => '138.8100',
        'close'  => '141.8600',
        'volume' => '65799349',
    ],
    '2023-01-26' => [
        'open'   => '143.1700',
        'high'   => '144.2500',
        'low'    => '141.9000',
        'close'  => '143.9600',
        'volume' => '54105068',
    ],
    // ...
]);
```

### Calculate individual indicators

- [SMA][c3Lg]
- [EMA][A88M]
- [+DI & -DI][AL9J]
- [ADX][YZeF]

[c3Lg]: #sma-simple-moving-average
[A88M]: #ema-exponential-moving-average
[AL9J]: #di---di-positive---negative-directional-indicator
[YZeF]: #adx-average-directional-index

#### SMA (Simple Moving Average)

```php
$period = 7;
$result = $chart->getSMA($period);

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '145.0414',
// '2023-02-03' => '146.8471',
// ...
```

#### EMA (Exponential Moving Average)

```php
$period = 7;
$result = $chart->getEMA($period);

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '145.6779',
// '2023-02-03' => '147.8834',
// ...
```

#### +DI & -DI (Positive- & Negative Directional Indicator)

```php
$period = 7;
$result = $chart->getDI($period);

// '2023-01-25' => [
//     'DIp' => null,
//     'DIm' => null,
// ],
// '2023-01-26' => [
//     'DIp' => null,
//     'DIm' => null,
// ],
// ...
// '2023-02-02' => [
//     'DIp' => '44.1913',
//     'DIm' =>  '3.0372',
// ],
// '2023-02-03' => [
//     'DIp' => '50.3535',
//     'DIm' =>  '2.1344',
// ],
// ...
```

#### ADX (Average Directional Index)

```php
$period = 7;
$result = $chart->getADX($period);

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-10' => '85.4433',
// '2023-02-13' => '83.2376',
// ...
```

### Calculate all indicators

Calculate all trend indicators (SMA, EMA, +DI, -DI and ADX) in a single run.

```php
$SMAPeriod = 20
$EMAPeriod = 10;
$result    = $chart->getTrend($SMAPeriod, $EMAPeriod);

// '2023-01-25' => [
//     'close' => '141.8600',
//     'SMA'   => null,
//     'EMA'   => null,
//     'DIp'   => null,
//     'DIm'   => null,
//     'ADX'   => null,
// ],
// ...
// '2023-02-07' => [
//     'close' => '154.6500',
//     'SMA'   => null,
//     'EMA'   => '148.8578',
//     'DIp'   =>  '45.1810',
//     'DIm'   =>   '1.8100',
//     'ADX'   => null,
// ],
// ...
// '2023-02-22' => [
//     'close' => '148.9100',
//     'SMA'   => '149.8000',
//     'EMA'   => '151.0938',
//     'DIp'   =>  '28.7024',
//     'DIm'   =>  '18.6931',
//     'ADX'   =>  '67.8187',
// ],
// ...
```

### FAQ

#### Why are numeric values represented as strings?

> Note about floating-point values: instantiating from a float might be unsafe, as floating-point values are imprecise by design, and could result in a loss of information. Always prefer instantiating from a string, which supports an unlimited number of digits.
>
> — [brick/math][R3EG]
