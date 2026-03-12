<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Kensho\Chart\Indicator\PrecisionTrait;
use Kensho\Chart\Indicator\WSMA\WSMAInterface;
use Override;

final readonly class ADX implements ADXInterface
{
	use PrecisionTrait;

	public function __construct(
		private WSMAInterface $WSMA,
	) {}

	/**
	 * @throws MathException
	 */
	#[Override]
	public function calculate(BigDecimal $DIp, BigDecimal $DIm): ?BigDecimal
	{
		/*
		 * Calculates the directional movement index (DI).
		 */

		$numerator = $DIp->minus($DIm)->abs();
		$denominator = $DIp->plus($DIm);

		if ($denominator->isZero()) {
			$DX = BigDecimal::zero();
		} else {
			$DX = $numerator->dividedBy($denominator, self::SCALE, self::ROUNDING_MODE)->multipliedBy(100);
		}

		/*
		 * Calculates the average directional movement index (ADX).
		 */

		return $this->WSMA->calculate($DX);
	}
}
