<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\MoveUp;

use Brick\Math\BigDecimal;

interface MoveUpInterface
{
    public function calculate(BigDecimal $high): BigDecimal;
}
