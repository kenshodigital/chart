<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use Kensho\Chart\Number;

/**
 * Calculates the average directional movement index (ADX).
 */
interface ADXInterface
{
    public function calculate(Number $DIp, Number $DIm): Number|null;
}
