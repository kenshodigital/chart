<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator;

use Brick\Math\RoundingMode;

/**
 * @internal
 */
trait PrecisionTrait
{
	private const ROUNDING_MODE = RoundingMode::HalfUp;
	private const SCALE = 20;
}
