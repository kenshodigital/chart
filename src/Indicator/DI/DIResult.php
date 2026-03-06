<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Brick\Math\BigDecimal;

final readonly class DIResult
{
	public function __construct(
		public ?BigDecimal $DIp,
		public ?BigDecimal $DIm,
	) {}
}
