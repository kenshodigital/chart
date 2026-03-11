<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

use Brick\Math\BigDecimal;

/**
 * Calculates the exponential moving average (EMA).
 *
 * @api
 */
interface EMAInterface
{
	public function calculate(BigDecimal $value): ?BigDecimal;
}
