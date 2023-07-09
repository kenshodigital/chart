<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\MoveDown;

use Brick\Math\BigDecimal;

interface MoveDownInterface
{
    public function calculate(BigDecimal $low): BigDecimal;
}
