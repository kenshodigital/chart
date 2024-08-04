# kenshō chart

Calculates [indicators][1] for [technical chart analysis][2] in [PHP][3].

## General

- [PHP 8.2][4]
- Minimal dependencies. 
- Uses [brick/math][5] for arbitrary precision numbers.
- Avoids redundant calculations and keeps the overall complexity low.
- Unit- and integration tested against [other libraries][6] and [real-world data][7].

### Audience

The library assumes a basic understanding of [technical analysis][2] and how to use these [indicators][1].

## Installation

```shell
composer require kenshodigital/chart ^2.1
```

## Usage

- [Prepare chart][8]
- [Calculate indicators][9]
- [Calculate trend indicators][10]

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

### Calculate indicators

- [SMA][11]
- [EMA][12]
- [+DI & -DI][13]
- [ADX][14]

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

### Calculate trend indicators

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
> — [brick/math][5]

 [1]: https://en.wikipedia.org/wiki/Technical_indicator
 [2]: https://en.wikipedia.org/wiki/Technical_analysis
 [3]: https://www.php.net
 [4]: https://www.php.net/releases/8.2/en.php
 [5]: https://github.com/brick/math
 [6]: https://github.com/bennycode/trading-signals
 [7]: https://www.alphavantage.co
 [8]: #prepare-chart
 [9]: #calculate-indicators
[10]: #calculate-trend-indicators
[11]: #sma-simple-moving-average
[12]: #ema-exponential-moving-average
[13]: #di---di-positive---negative-directional-indicator
[14]: #adx-average-directional-index
