<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\TR;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;

final class TR implements TRInterface
{
    private BigDecimal|null $previousClose;

    public function __construct()
    {
        $this->previousClose = null;
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $high, BigDecimal $low, BigDecimal $close): BigDecimal
    {
        $previousClose       = $this->previousClose;
        $this->previousClose = $close;
        $highLow             = $high->minus($low);

        if ($previousClose !== null) {
            $highClose     = $high->minus($previousClose);
            $absHighClose  = $highClose->abs();
            $lowClose      = $low->minus($previousClose);
            $absLowClose   = $lowClose->abs();

            return BigDecimal::max($highLow, $absHighClose, $absLowClose);
        }
        return $highLow;
    }
}
