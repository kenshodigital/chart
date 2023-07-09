<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DX;

use Brick\Math\BigDecimal;

interface DXInterface
{
    public static function calculate(BigDecimal $DIp, BigDecimal $DIm): BigDecimal;
}
