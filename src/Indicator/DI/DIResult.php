<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Kensho\Chart\Number;

final readonly class DIResult
{
    public function __construct(
        public Number|null $DIp,
        public Number|null $DIm,
    ) {}
}
