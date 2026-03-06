<?php declare(strict_types=1);

namespace Kensho\Chart;

/**
 * Trend indicators.
 */
final readonly class Trend
{
	public function __construct(
		public ?string $close,
		public ?string $SMA,
		public ?string $EMA,
		public ?string $DIp,
		public ?string $DIm,
		public ?string $ADX,
	) {}
}
