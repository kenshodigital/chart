<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Trend;

use Brick\Math\BigDecimal;

final readonly class TrendResult
{
    public function __construct(
        public BigDecimal|null $SMA,
        public BigDecimal|null $EMA,
        public BigDecimal|null $DIp,
        public BigDecimal|null $DIm,
        public BigDecimal|null $ADX,
    ) {}
}
