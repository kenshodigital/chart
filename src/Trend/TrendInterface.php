<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Trend;

use Kensho\TechnicalIndicators\DataPoint;

interface TrendInterface
{
    public function calculate(DataPoint $dataPoint): TrendResult;
}
