<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DIx;

use Brick\Math\BigDecimal;

interface DIxInterface
{
    public static function calculate(BigDecimal $DMxSMA, BigDecimal $ATR): BigDecimal;
}
