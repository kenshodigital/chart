<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DI;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Kensho\Indicators\Indicator\PrecisionTrait;
use Kensho\Indicators\Indicator\WSMA\WSMAInterface;

final readonly class DI implements DIInterface
{
    use PrecisionTrait;

    public function __construct(
        private WSMAInterface $DMpSMA,
        private WSMAInterface $DMmSMA,
        private WSMAInterface $ATR,
    ) {}

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $DMp, BigDecimal $DMm, BigDecimal $TR): DIResult
    {
        /*
         * Calculates the smoothed moving averages
         * of directional movements (+DM & -DM).
         */

        $DMpSMA = $this->DMpSMA->calculate($DMp);
        $DMmSMA = $this->DMmSMA->calculate($DMm);

        /*
         * Calculates the average true range (ATR).
         */

        $ATR = $this->ATR->calculate($TR);
        $DIp = null;
        $DIm = null;

        if ($DMpSMA !== null && $DMmSMA !== null && $ATR !== null) {

            /*
             * Calculates the directional indicators (+DI & -DI).
             */

            if ($ATR->isZero()) {
                $DIp = BigDecimal::zero();
                $DIm = BigDecimal::zero();
            } else {
                $DIp = $DMpSMA->dividedBy($ATR, self::SCALE, self::ROUNDING_MODE)->multipliedBy(100);
                $DIm = $DMmSMA->dividedBy($ATR, self::SCALE, self::ROUNDING_MODE)->multipliedBy(100);
            }
        }
        return new DIResult(
            $DIp,
            $DIm,
        );
    }
}
