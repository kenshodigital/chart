<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\SMA;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use DomainException;
use Kensho\Indicators\Indicator\PrecisionTrait;
use function array_shift;
use function sprintf;

final class SMA implements SMAInterface
{
    use PrecisionTrait;

    private int        $period;
    /**
     * @var array<BigDecimal>
     */
    private array      $buffer;
    private int        $bufferSize;
    private BigDecimal $sum;

    public function __construct(int $period)
    {
        if ($period < 2) {
            throw new DomainException(sprintf(
                'Invalid period: `%d`. Period must be higher than `1` for SMA calculation.',
                $period,
            ));
        }

        $this->period     = $period;
        $this->buffer     = [];
        $this->bufferSize = 0;
        $this->sum        = BigDecimal::zero();
    }

    /**
     * @throws MathException
     */
    public function calculate(BigDecimal $value): BigDecimal|null
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
        return $this->sum->dividedBy($this->period, self::SCALE, self::ROUNDING_MODE);
    }
}
