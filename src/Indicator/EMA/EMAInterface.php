<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

use Kensho\Chart\Number;

/**
 * Calculates the exponential moving average (EMA).
 */
interface EMAInterface
{
    public function calculate(Number $value): Number|null;
}
