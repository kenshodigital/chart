# Technical Indicators

Calculates [indicators][1] for [technical analysis][2] in [PHP][3].

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
composer require kenshodigital/technical-indicators ^1.0
```

## Usage

### Utilities

- [Trend][8]

#### Trend

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Utility\Candle;
use Kensho\Indicators\Utility\Chart\ChartFactory;
use Kensho\Indicators\Utility\Trend\TrendFactory;

$SMAPeriod = 7;
$EMAPeriod = 3;
$chart     = ChartFactory::create();
$trend     = TrendFactory::create($SMAPeriod, $EMAPeriod);
$result    = [];
$values    = [
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
];

foreach ($values as $date => [
    'open'   => $open,
    'high'   => $high,
    'low'    => $low,
    'close'  => $close,
    'volume' => $volume,
]) {
    $trendResult = $trend->calculate(
        $chart->calculate(
            new Candle(
                BigDecimal::of($open),
                BigDecimal::of($high),
                BigDecimal::of($low),
                BigDecimal::of($close),
                BigInteger::of($volume),
            ),    
        ),    
    );
    $result[$date] = [
        'SMA' => $trendResult->SMA?->toScale(4, RoundingMode::HALF_UP)->__toString(),
        'EMA' => $trendResult->EMA?->toScale(4, RoundingMode::HALF_UP)->__toString(),
        'DIp' => $trendResult->DIp?->toScale(4, RoundingMode::HALF_UP)->__toString(),
        'DIm' => $trendResult->DIm?->toScale(4, RoundingMode::HALF_UP)->__toString(),
        'ADX' => $trendResult->ADX?->toScale(4, RoundingMode::HALF_UP)->__toString(),
    ];            
}

// '2023-01-25' => [
//     'SMA' => null,
//     'EMA' => null,
//     'DIp' => null,
//     'DIm' => null,
//     'ADX' => null,
// ], 
// ... 
// '2023-01-30' => [
//     'SMA' => null,
//     'EMA' => '143.7100',
//     'DIp' =>  '32.4763',
//     'DIm' =>   '2.3342',
//     'ADX' => null,
// ],
// '2023-01-31' => [
//     'SMA' => null,
//     'EMA' => '144.0000',
//     'DIp' =>  '24.7232',
//     'DIm' =>   '8.3827',
//     'ADX' =>  '78.6490',
// ],
// ...
// '2023-02-02' => [
//     'SMA' => '145.0414',
//     'EMA' => '147.7675',
//     'DIp' =>  '53.6274',
//     'DIm' =>   '2.4519',
//     'ADX' =>  '82.4618',
// ],
// ...
```

### Indicators

- [SMA][9]
- [EMA][10]
- [+DI][11]
- [-DI][12]
- [ADX][13]

#### SMA (Simple Moving Average)

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Indicator\SMA\SMA;

$period = 7;
$SMA    = new SMA($period);
$result = [];
$values = [
    '2023-01-25' => '141.8600',
    '2023-01-26' => '143.9600',
    // ...
];

foreach ($values as $date => $value) {
    $SMAResult     = $SMA->calculate(BigDecimal::of($value));
    $result[$date] = $SMAResult?->toScale(4, RoundingMode::HALF_UP)->__toString(); 
}

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '145.0414',
// '2023-02-03' => '146.8471',
// ...
```

#### EMA (Exponential Moving Average)

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Indicator\EMA\EMA;

$period = 7;
$EMA    = new EMA($period);
$result = [];
$values = [
    '2023-01-25' => '141.8600',
    '2023-01-26' => '143.9600',
    // ...
];

foreach ($values as $date => $value) {
    $EMAResult     = $EMA->calculate(BigDecimal::of($value));
    $result[$date] = $EMAResult?->toScale(4, RoundingMode::HALF_UP)->__toString(); 
}

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '145.6779',
// '2023-02-03' => '147.8834',
// ...
```

#### +DI (Positive Directional Indicator)

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Indicator\DIx\DIx;
use Kensho\Indicators\Indicator\DMp\DMp;
use Kensho\Indicators\Indicator\MoveDown\MoveDown;
use Kensho\Indicators\Indicator\MoveUp\MoveUp;
use Kensho\Indicators\Indicator\TR\TR;
use Kensho\Indicators\Indicator\WSMA\WSMA;

$period   = 7;
$moveUp   = new MoveUp;
$moveDown = new MoveDown;
$DMpSMA   = new WSMA($period);
$TR       = new TR;
$ATR      = new WSMA($period);
$result   = [];
$values   = [
    '2023-01-25' => [
        'high'  => '142.4300',
        'low'   => '138.8100',
        'close' => '141.8600',
    ],
    '2023-01-26' => [
        'high'  => '144.2500',
        'low'   => '141.9000',
        'close' => '143.9600',
    ],
    // ...
];

foreach ($values as $date => [
    'high'  => $high,
    'low'   => $low,
    'close' => $close,
]) {
    $high           = BigDecimal::of($high);
    $moveUpResult   = $moveUp->calculate($high);
    $low            = BigDecimal::of($low);
    $moveDownResult = $moveDown->calculate($low);    
    $DMpResult      = DMp::calculate($moveUpResult, $moveDownResult);
    $DMpSMAResult   = $DMpSMA->calculate($DMpResult);
    $close          = BigDecimal::of($close);
    $TRResult       = $TR->calculate($high, $low, $close);    
    $ATRResult      = $ATR->calculate($TRResult);
    $result[$date]  = null;
    
    if ($DMpSMAResult !== null && $ATRResult !== null) {
        $DIpResult     = DIx::calculate($DMpSMAResult, $ATRResult);
        $result[$date] = $DIpResult->toScale(4, RoundingMode::HALF_UP)->__toString();
    }
}

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '44.1913',
// '2023-02-03' => '50.3535',
// ...
```

#### -DI (Negative Directional Indicator)

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Indicator\DIx\DIx;
use Kensho\Indicators\Indicator\DMm\DMm;
use Kensho\Indicators\Indicator\MoveDown\MoveDown;
use Kensho\Indicators\Indicator\MoveUp\MoveUp;
use Kensho\Indicators\Indicator\TR\TR;
use Kensho\Indicators\Indicator\WSMA\WSMA;

$period   = 7;
$moveUp   = new MoveUp;
$moveDown = new MoveDown;
$DMmSMA   = new WSMA($period);
$TR       = new TR;
$ATR      = new WSMA($period);
$result   = [];
$values   = [
    '2023-01-25' => [
        'high'  => '142.4300',
        'low'   => '138.8100',
        'close' => '141.8600',
    ],
    '2023-01-26' => [
        'high'  => '144.2500',
        'low'   => '141.9000',
        'close' => '143.9600',
    ],
    // ...
];

foreach ($values as $date => [
    'high'  => $high,
    'low'   => $low,
    'close' => $close,
]) {
    $low            = BigDecimal::of($low);
    $moveDownResult = $moveDown->calculate($low);
    $high           = BigDecimal::of($high);
    $moveUpResult   = $moveUp->calculate($high);    
    $DMmResult      = DMm::calculate($moveDownResult, $moveUpResult);
    $DMmSMAResult   = $DMmSMA->calculate($DMmResult);
    $close          = BigDecimal::of($close);
    $TRResult       = $TR->calculate($high, $low, $close);    
    $ATRResult      = $ATR->calculate($TRResult);
    $result[$date]  = null;
    
    if ($DMmSMAResult !== null && $ATRResult !== null) {
        $DImResult     = DIx::calculate($DMmSMAResult, $ATRResult);
        $result[$date] = $DImResult->toScale(4, RoundingMode::HALF_UP)->__toString();
    }
}

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-02' => '3.0372',
// '2023-02-03' => '2.1344',
// ...
```

#### ADX (Average Directional Index)

```php
<?php declare(strict_types=1);

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Indicator\DIx\DIx;
use Kensho\Indicators\Indicator\DMm\DMm;
use Kensho\Indicators\Indicator\DMm\DMp;
use Kensho\Indicators\Indicator\MoveDown\MoveDown;
use Kensho\Indicators\Indicator\MoveUp\MoveUp;
use Kensho\Indicators\Indicator\TR\TR;
use Kensho\Indicators\Indicator\WSMA\WSMA;

$period   = 7;
$moveUp   = new MoveUp;
$moveDown = new MoveDown;
$DMpSMA   = new WSMA($period);
$DMmSMA   = new WSMA($period);
$TR       = new TR;
$ATR      = new WSMA($period);
$ADX      = new WSMA($period);
$result   = [];
$values   = [
    '2023-01-25' => [
        'high'  => '142.4300',
        'low'   => '138.8100',
        'close' => '141.8600',
    ],
    '2023-01-26' => [
        'high'  => '144.2500',
        'low'   => '141.9000',
        'close' => '143.9600',
    ],
    // ...
];

foreach ($values as $date => [
    'high'  => $high,
    'low'   => $low,
    'close' => $close,
]) {
    $high           = BigDecimal::of($high);
    $moveUpResult   = $moveUp->calculate($high);    
    $low            = BigDecimal::of($low);
    $moveDownResult = $moveDown->calculate($low);
    $DMpResult      = DMp::calculate($moveUpResult, $moveDownResult);
    $DMpSMAResult   = $DMpSMA->calculate($DMpResult);
    $DMmResult      = DMm::calculate($moveDownResult, $moveUpResult);
    $DMmSMAResult   = $DMmSMA->calculate($DMmResult);
    $close          = BigDecimal::of($close);
    $TRResult       = $TR->calculate($high, $low, $close);    
    $ATRResult      = $ATR->calculate($TRResult);
    $result[$date]  = null;
    
    if ($DMpSMAResult !== null && $DMmSMAResult !== null && $ATRResult !== null) {
        $DIpResult     = DIx::calculate($DMpSMAResult, $ATRResult);
        $DImResult     = DIx::calculate($DMmSMAResult, $ATRResult);
        $DXResult      = DX::calculate($DIpResult, $DImResult);
        $ADXResult     = $ADX->calculate($DXResult);
        $result[$date] = $ADXResult?->toScale(4, RoundingMode::HALF_UP)->__toString();
    }
}

// '2023-01-25' => null,
// '2023-01-26' => null,
// ...
// '2023-02-10' => '85.4433',
// '2023-02-13' => '83.2376',
// ...
```

 [1]: https://en.wikipedia.org/wiki/Technical_indicator
 [2]: https://en.wikipedia.org/wiki/Technical_analysis
 [3]: https://www.php.net
 [4]: https://www.php.net/releases/8.2/en.php
 [5]: https://github.com/brick/math
 [6]: https://github.com/bennycode/trading-signals
 [7]: https://www.alphavantage.co
 [8]: #trend
 [9]: #sma-simple-moving-average
[10]: #ema-exponential-moving-average
[11]: #di-positive-directional-indicator
[12]: #-di-negative-directional-indicator
[13]: #adx-average-directional-index
