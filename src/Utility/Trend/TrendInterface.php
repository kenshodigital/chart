<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Trend;

use Kensho\Indicators\Utility\DataPoint;

interface TrendInterface
{
    public function calculate(DataPoint $dataPoint): TrendResult;
}
