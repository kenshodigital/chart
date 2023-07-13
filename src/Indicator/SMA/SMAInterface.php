<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\SMA;

use Brick\Math\BigDecimal;

/**
 * Calculates the simple moving average (SMA).
 */
interface SMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
