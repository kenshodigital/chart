<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\MoveDown;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;

final class MoveDown implements MoveDownInterface
{
    private BigDecimal|null $previousLow;

    public function __construct()
    {
        $this->previousLow = null;
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $low): BigDecimal
    {
        $previousLow       = $this->previousLow;
        $this->previousLow = $low;

        if ($previousLow !== null) {
            return $previousLow->minus($low);
        }
        return BigDecimal::zero();
    }
}
