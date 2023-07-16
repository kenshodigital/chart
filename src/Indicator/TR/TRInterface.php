<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\TR;

use Brick\Math\BigDecimal;

interface TRInterface
{
    public function calculate(BigDecimal $high, BigDecimal $low, BigDecimal $close): BigDecimal;
}
