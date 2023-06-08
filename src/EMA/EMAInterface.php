<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\EMA;

use Brick\Math\BigDecimal;

interface EMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
