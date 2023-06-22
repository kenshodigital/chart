<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\MoveDown;

use Brick\Math\BigDecimal;

interface MoveDownInterface
{
    public function calculate(BigDecimal $low): BigDecimal;
}
