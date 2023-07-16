<?php declare(strict_types=1);

namespace Kensho\Chart;

/**
 * Trend indicators.
 */
final readonly class Trend
{
    public function __construct(
        public string|null $SMA,
        public string|null $EMA,
        public string|null $DIp,
        public string|null $DIm,
        public string|null $ADX,
    ) {}
}
