<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

use DomainException;
use Kensho\Chart\Number;

final class EMA implements EMAInterface
{
    private readonly int $period;
    private readonly Number $weightingFactor;
    private int $dataCount;
    private Number|null $result;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(
                message: 'Invalid period. Period must be higher than `1` for EMA calculation.'
            );
        }

        $this->period          = $period;
        $this->weightingFactor = (new Number(value: 2))->dividedBy(value: $period + 1);
        $this->dataCount       = 0;
        $this->result          = null;
    }

    public function calculate(Number $value): Number|null
    {
        if ($this->result === null) {
            $this->result = $value;
        } else {
            $value        = $value->minus(value: $this->result);
            $weighted     = $value->multipliedBy(value: $this->weightingFactor);
            $this->result = $this->result->plus(value: $weighted);
        }
        if (++$this->dataCount < $this->period) {
            return null;
        } else {
            return $this->result;
        }
    }
}
