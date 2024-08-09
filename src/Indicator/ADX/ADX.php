<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use Kensho\Chart\Indicator\WSMA\WSMAInterface;
use Kensho\Chart\Number;

final readonly class ADX implements ADXInterface
{
    public function __construct(
        private WSMAInterface $WSMA,
    ) {}

    public function calculate(Number $DIp, Number $DIm): Number|null
    {
        /*
         * Calculates the directional movement index (DI).
         */

        $numerator   = $DIp->minus($DIm)->abs();
        $denominator = $DIp->plus($DIm);

        if ($denominator->isZero()) {
            $DX = new Number(0);
        } else {
            $DX = $numerator->dividedBy($denominator)->multipliedBy(100);
        }

        /*
         * Calculates the average directional movement index (ADX).
         */

        return $this->WSMA->calculate($DX);
    }
}
