<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Chart;

use Kensho\TechnicalIndicators\Candle;
use Kensho\TechnicalIndicators\DataPoint;

interface ChartInterface
{
    public function calculate(Candle $candle): DataPoint;
}
