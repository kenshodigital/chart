<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\DMp;

use Brick\Math\BigDecimal;

final readonly class DMp implements DMpInterface
{
    public static function calculate(BigDecimal $moveUp, BigDecimal $moveDown): BigDecimal
    {
        return $moveUp->isPositive() && $moveUp->isGreaterThan($moveDown)
             ? $moveUp
             : BigDecimal::zero();
    }
}
