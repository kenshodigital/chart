<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\ADX;

use Brick\Math\BigDecimal;

/**
 * Calculates the average directional movement index (ADX).
 */
interface ADXInterface
{
    public function calculate(BigDecimal $DIp, BigDecimal $DIm): BigDecimal|null;
}
