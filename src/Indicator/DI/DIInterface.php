<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Brick\Math\BigDecimal;

/**
 * Calculates the directional indicators (+DI & -DI).
 */
interface DIInterface
{
    public function calculate(BigDecimal $DMp, BigDecimal $DMm, BigDecimal $TR): DIResult;
}
