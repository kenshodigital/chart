<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Kensho\Chart\Number;

/**
 * Calculates the directional indicators (+DI & -DI).
 */
interface DIInterface
{
    public function calculate(Number $DMp, Number $DMm, Number $TR): DIResult;
}
