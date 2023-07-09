<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DX;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Kensho\Indicators\Indicator\PrecisionTrait;

final readonly class DX implements DXInterface
{
    use PrecisionTrait;

    /**
     * @throws MathException
     */
    public static function calculate(BigDecimal $DIp, BigDecimal $DIm): BigDecimal
    {
        $numerator   = $DIp->minus($DIm)->abs();
        $denominator = $DIp->plus($DIm);

        if ($denominator->isZero()) {
            return BigDecimal::zero();
        } else {
            return $numerator->dividedBy($denominator, self::SCALE, self::ROUNDING_MODE)->multipliedBy(100);
        }
    }
}
