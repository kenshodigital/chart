<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

use DomainException;
use Kensho\Chart\Number;
use function array_shift;

final class SMA implements SMAInterface
{
    private readonly int $period;
    /**
     * @var array<Number>
     */
    private array $buffer;
    private int $bufferSize;
    private Number $sum;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(
                message: 'Invalid period. Period must be higher than `1` for SMA calculation.'
            );
        }

        $this->period     = $period;
        $this->buffer     = [];
        $this->bufferSize = 0;
        $this->sum        = new Number(value: 0);
    }

    public function calculate(Number $value): Number|null
    {
        $this->buffer[] = $value;
        $this->sum      = $this->sum->plus(value: $value);
        $this->bufferSize++;

        if ($this->bufferSize < $this->period) {
            return null;
        }
        if ($this->bufferSize > $this->period) {
            $oldest    = array_shift(array: $this->buffer);
            $this->sum = $this->sum->minus(value: $oldest);
            $this->bufferSize--;
        }
        return $this->sum->dividedBy(value: $this->period);
    }
}
