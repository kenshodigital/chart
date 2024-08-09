<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

use DomainException;
use Kensho\Chart\Number;

final class SMA implements SMAInterface
{
    private int    $period;
    /**
     * @var array<Number>
     */
    private array  $buffer;
    private int    $bufferSize;
    private Number $sum;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(
                'Invalid period. Period must be higher than `1` for SMA calculation.'
            );
        }

        $this->period     = $period;
        $this->buffer     = [];
        $this->bufferSize = 0;
        $this->sum        = new Number(0);
    }

    public function calculate(Number $value): Number|null
    {
        $this->buffer[] = $value;
        $this->sum      = $this->sum->plus($value);
        $this->bufferSize++;

        if ($this->bufferSize < $this->period) {
            return null;
        }
        if ($this->bufferSize > $this->period) {
            $oldest    = array_shift($this->buffer);
            $this->sum = $this->sum->minus($oldest);
            $this->bufferSize--;
        }
        return $this->sum->dividedBy($this->period);
    }
}
