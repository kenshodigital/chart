<?php declare(strict_types=1);

namespace Kensho\Indicators;

final readonly class DI
{
    public function __construct(
        public string|null $DIp,
        public string|null $DIm,
    ) {}
}
