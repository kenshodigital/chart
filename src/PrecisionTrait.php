<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators;

use Brick\Math\RoundingMode;

trait PrecisionTrait
{
    private const ROUNDING_MODE = RoundingMode::HALF_UP;
    private const SCALE         = 20;
}
