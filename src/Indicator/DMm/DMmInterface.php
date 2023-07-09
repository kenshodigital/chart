<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DMm;

use Brick\Math\BigDecimal;

interface DMmInterface
{
    public static function calculate(BigDecimal $moveDown, BigDecimal $moveUp): BigDecimal;
}
