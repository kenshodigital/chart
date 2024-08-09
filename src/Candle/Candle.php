<?php declare(strict_types=1);

namespace Kensho\Chart\Candle;

use DomainException;
use Kensho\Chart\Number;

/**
 * Open price, high price, low price, close price, volume,
 * true range (TR) & directional movement (+DM & -DM).
 */
final readonly class Candle
{
    public function __construct(
        public Number $open,
        public Number $high,
        public Number $low,
        public Number $close,
        public Number $volume,
        public Number $TR,
        public Number $DMp,
        public Number $DMm,
    ) {
        if ($open->isNegative()) {
            throw new DomainException(
                message: 'Invalid open price. Open price must not be negative.'
            );
        }
        if ($high->isNegative()) {
            throw new DomainException(
                message: 'Invalid high price. High price must not be negative.'
            );
        }
        if ($low->isNegative()) {
            throw new DomainException(
                message: 'Invalid low price. Low price must not be negative.'
            );
        }
        if ($high->isLessThan($low)) {
            throw new DomainException(
                message: 'Invalid high- and low price. High price must not be lower than low price.'
            );
        }
        if ($close->isNegative()) {
            throw new DomainException(
                message: 'Invalid close price. Close price must not be negative.'
            );
        }
        if ($volume->isNegative()) {
            throw new DomainException(
                message: 'Invalid volume. Volume must not be negative.'
            );
        }
    }
}
