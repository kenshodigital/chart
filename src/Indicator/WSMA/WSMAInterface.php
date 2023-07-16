<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\WSMA;

use Brick\Math\BigDecimal;

/**
 * Calculates Wilder’s smoothed moving average.
 */
interface WSMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
