<?php declare(strict_types=1);

namespace Kensho\Chart\Candle;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use DomainException;

final readonly class Candle
{
    public function __construct(
        public BigDecimal $open,
        public BigDecimal $high,
        public BigDecimal $low,
        public BigDecimal $close,
        public BigInteger $volume,
        public BigDecimal $TR,
        public BigDecimal $DMp,
        public BigDecimal $DMm,
    ) {
        if ($open->isNegative()) {
            throw new DomainException(
                'Invalid open price. Open price must not be negative.'
            );
        }
        if ($high->isNegative()) {
            throw new DomainException(
                'Invalid high price. High price must not be negative.'
            );
        }
        if ($low->isNegative()) {
            throw new DomainException(
                'Invalid low price. Low price must not be negative.'
            );
        }
        if ($high->isLessThan($low)) {
            throw new DomainException(
                'Invalid high- and low price. High price must not be lower than low price.'
            );
        }
        if ($close->isNegative()) {
            throw new DomainException(
                'Invalid close price. Close price must not be negative.'
            );
        }
        if ($volume->isNegative()) {
            throw new DomainException(
                'Invalid volume. Volume must not be negative.'
            );
        }
    }
}
