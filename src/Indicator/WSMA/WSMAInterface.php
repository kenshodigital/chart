<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\WSMA;

use Brick\Math\BigDecimal;

interface WSMAInterface
{
    public function calculate(BigDecimal $value): BigDecimal|null;
}
