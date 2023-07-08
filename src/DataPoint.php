<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators;

use Brick\Math\BigDecimal;

final readonly class DataPoint
{
    public function __construct(
        public Candle     $candle,
        public BigDecimal $DMp,
        public BigDecimal $DMm,
        public BigDecimal $TR,
    ) {}
}
