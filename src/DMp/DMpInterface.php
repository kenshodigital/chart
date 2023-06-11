<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\DMp;

use Brick\Math\BigDecimal;

interface DMpInterface
{
    public static function calculate(BigDecimal $moveUp, BigDecimal $moveDown): BigDecimal;
}
