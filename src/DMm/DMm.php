<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\DMm;

use Brick\Math\BigDecimal;

final readonly class DMm implements DMmInterface
{
    public static function calculate(BigDecimal $moveDown, BigDecimal $moveUp): BigDecimal
    {
        return $moveDown->isPositive() && $moveDown->isGreaterThan($moveUp)
             ? $moveDown
             : BigDecimal::zero();
    }
}
