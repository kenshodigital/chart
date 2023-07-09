<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Math\RoundingMode;
use DomainException;
use function sprintf;

final readonly class Candle
{
    /**
     * @throws RoundingNecessaryException
     */
    public function __construct(
        public BigDecimal $open,
        public BigDecimal $high,
        public BigDecimal $low,
        public BigDecimal $close,
        public BigInteger $volume,
    ) {
        if ($open->isNegative()) {
            throw new DomainException(sprintf(
                'Invalid open price: `%s`. Open price must not be negative.',
                $open->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
            ));
        }
        if ($high->isNegative()) {
            throw new DomainException(sprintf(
                'Invalid high price: `%s`. High price must not be negative.',
                $high->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
            ));
        }
        if ($low->isNegative()) {
            throw new DomainException(sprintf(
                'Invalid low price: `%s`. Low price must not be negative.',
                $low->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
            ));
        }
        if ($high->isLessThan($low)) {
            throw new DomainException(sprintf(
                'Invalid high and low prices: High price `%s` must not be lower than low price `%s`.',
                $high->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
                $low->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
            ));
        }
        if ($close->isNegative()) {
            throw new DomainException(sprintf(
                'Invalid close price: `%s`. Close price must not be negative.',
                $close->toScale(
                    4,
                    RoundingMode::HALF_UP,
                )->__toString(),
            ));
        }
        if ($volume->isNegative()) {
            throw new DomainException(sprintf(
                'Invalid volume: `%s`. Volume must not be negative.',
                $volume->__toString(),
            ));
        }
    }
}
