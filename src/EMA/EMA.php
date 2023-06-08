<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\EMA;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use DomainException;
use Kensho\TechnicalIndicators\PrecisionTrait;
use function sprintf;

final class EMA implements EMAInterface
{
    use PrecisionTrait;

    private int             $period;
    private BigDecimal      $weightingFactor;
    private int             $dataCount;
    private BigDecimal|null $result;

    /**
     * @throws MathException
     */
    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(sprintf(
                'Invalid period: `%d`. Period must be higher than `1` for EMA calculation.',
                $period,
            ));
        }

        $this->period          = $period;
        $this->weightingFactor = BigDecimal::of(2)->dividedBy($period + 1, self::SCALE, self::ROUNDING_MODE);
        $this->dataCount       = 0;
        $this->result          = null;
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $value): BigDecimal|null
    {
        if ($this->result === null) {
            $this->result = $value;
        } else {
            $value        = $value->minus($this->result);
            $weighted     = $value->multipliedBy($this->weightingFactor);
            $this->result = $this->result->plus($weighted);
        }
        if (++$this->dataCount < $this->period) {
            return null;
        } else {
            return $this->result;
        }
    }
}
