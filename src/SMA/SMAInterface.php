<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\SMA;

use Brick\Math\BigDecimal;

interface SMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
