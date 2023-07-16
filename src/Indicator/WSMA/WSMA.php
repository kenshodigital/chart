<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\WSMA;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use DomainException;
use Kensho\Chart\Indicator\PrecisionTrait;

final class WSMA implements WSMAInterface
{
    use PrecisionTrait;

    private int             $period;
    private int             $weightingFactor;
    private int             $initialDataCount;
    private BigDecimal      $initialSum;
    private BigDecimal|null $result;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(
                'Invalid period. Period must be higher than `1` for WSMA calculation.'
            );
        }

        $this->period           = $period;
        $this->weightingFactor  = $period - 1;
        $this->initialDataCount = 0;
        $this->initialSum       = BigDecimal::zero();
        $this->result           = null;
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $value): BigDecimal|null
    {
        if ($this->result === null) {
            $this->initialSum = $this->initialSum->plus($value);
            $this->initialDataCount++;

            if ($this->initialDataCount === $this->period) {
                $this->result = $this->initialSum->dividedBy($this->period, self::SCALE, self::ROUNDING_MODE);
            }
        } else {
            $weighted     = $this->result->multipliedBy($this->weightingFactor);
            $sum          = $weighted->plus($value);
            $this->result = $sum->dividedBy($this->period, self::SCALE, self::ROUNDING_MODE);
        }
        return $this->result;
    }
}
