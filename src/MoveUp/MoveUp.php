<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\MoveUp;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;

final class MoveUp implements MoveUpInterface
{
    private BigDecimal|null $previousHigh;

    public function __construct()
    {
        $this->previousHigh = null;
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $high): BigDecimal
    {
        $previousHigh       = $this->previousHigh;
        $this->previousHigh = $high;

        if ($previousHigh !== null) {
            return $high->minus($previousHigh);
        }
        return BigDecimal::zero();
    }
}
