<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\WSMA;

use DomainException;
use Kensho\Chart\Number;

final class WSMA implements WSMAInterface
{
    private readonly int $period;
    private readonly int $weightingFactor;
    private int $initialDataCount;
    private Number $initialSum;
    private Number|null $result;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(
                message: 'Invalid period. Period must be higher than `1` for WSMA calculation.'
            );
        }

        $this->period           = $period;
        $this->weightingFactor  = $period - 1;
        $this->initialDataCount = 0;
        $this->initialSum       = new Number(value: 0);
        $this->result           = null;
    }

    public function calculate(Number $value): Number|null
    {
        if ($this->result === null) {
            $this->initialSum = $this->initialSum->plus(value: $value);
            $this->initialDataCount++;

            if ($this->initialDataCount === $this->period) {
                $this->result = $this->initialSum->dividedBy(value: $this->period);
            }
        } else {
            $weighted     = $this->result->multipliedBy(value: $this->weightingFactor);
            $sum          = $weighted->plus(value: $value);
            $this->result = $sum->dividedBy(value: $this->period);
        }
        return $this->result;
    }
}
