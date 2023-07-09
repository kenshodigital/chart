<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Chart;

use Kensho\Indicators\Utility\Candle;
use Kensho\Indicators\Utility\DataPoint;

interface ChartInterface
{
    public function calculate(Candle $candle): DataPoint;
}
