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
                $DIp = new Number(0);
                $DIm = new Number(0);
            } else {
                $DIp = $DMpSMA->dividedBy($ATR)->multipliedBy(100);
                $DIm = $DMmSMA->dividedBy($ATR)->multipliedBy(100);
            }
        }
        return new DIResult(
            $DIp,
            $DIm,
        );
    }
}
