<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\MoveUp;

use Brick\Math\BigDecimal;

interface MoveUpInterface
{
    public function calculate(BigDecimal $high): BigDecimal;
}
