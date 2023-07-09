<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\EMA;

use Brick\Math\BigDecimal;

interface EMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
