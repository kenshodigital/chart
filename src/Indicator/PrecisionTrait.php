<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator;

use Brick\Math\RoundingMode;

/**
 * @internal
 */
trait PrecisionTrait
{
	private const RoundingMode ROUNDING_MODE = RoundingMode::HalfUp;
	private const int SCALE = 20;
}
