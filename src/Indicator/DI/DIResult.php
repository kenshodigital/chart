<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\DI;

use Brick\Math\BigDecimal;

final readonly class DIResult
{
    public function __construct(
        public BigDecimal|null $DIp,
        public BigDecimal|null $DIm,
    ) {}
}
