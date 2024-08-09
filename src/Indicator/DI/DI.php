<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Kensho\Chart\Indicator\WSMA\WSMAInterface;
use Kensho\Chart\Number;

final readonly class DI implements DIInterface
{
    public function __construct(
        private WSMAInterface $DMpSMA,
        private WSMAInterface $DMmSMA,
        private WSMAInterface $ATR,
    ) {}

    public function calculate(Number $DMp, Number $DMm, Number $TR): DIResult
    {
        /*
         * Calculates the smoothed moving averages
         * of directional movements (+DM & -DM).
         */

        $DMpSMA = $this->DMpSMA->calculate(value: $DMp);
        $DMmSMA = $this->DMmSMA->calculate(value: $DMm);

        /*
         * Calculates the average true range (ATR).
         */

        $ATR = $this->ATR->calculate(value: $TR);
        $DIp = null;
        $DIm = null;

        if ($DMpSMA !== null && $DMmSMA !== null && $ATR !== null) {

            /*
             * Calculates the directional indicators (+DI & -DI).
             */

            if ($ATR->isZero()) {
                $DIp = new Number(value: 0);
                $DIm = new Number(value: 0);
            } else {
                $DIp = $DMpSMA->dividedBy(value: $ATR)->multipliedBy(value: 100);
                $DIm = $DMmSMA->dividedBy(value: $ATR)->multipliedBy(value: 100);
            }
        }
        return new DIResult(DIp: $DIp, DIm: $DIm);
    }
}
