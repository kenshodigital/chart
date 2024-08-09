<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\WSMA;

use Kensho\Chart\Number;

/**
 * Calculates Wilder’s smoothed moving average.
 */
interface WSMAInterface
{
    public function calculate(Number $value): Number|null;
}
