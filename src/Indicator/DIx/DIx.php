<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DIx;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Kensho\Indicators\Indicator\PrecisionTrait;

final readonly class DIx implements DIxInterface
{
    use PrecisionTrait;

    /**
     * @throws MathException
     */
    public static function calculate(BigDecimal $DMxSMA, BigDecimal $ATR): BigDecimal
    {
        if ($ATR->isZero()) {
            return BigDecimal::zero();
        } else {
            return $DMxSMA->dividedBy($ATR, self::SCALE, self::ROUNDING_MODE)->multipliedBy(100);
        }
    }
}