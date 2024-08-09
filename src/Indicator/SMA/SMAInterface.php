<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

use Kensho\Chart\Number;

/**
 * Calculates the simple moving average (SMA).
 */
interface SMAInterface
{
    public function calculate(Number $value): Number|null;
}
