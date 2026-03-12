<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

use Brick\Math\Exception\MathException;
use DomainException;
use Override;

final readonly class EMAFactory implements EMAFactoryInterface
{
	/**
	 * @throws DomainException
	 * @throws MathException
	 */
	#[Override]
	public static function create(int $period): EMAInterface
	{
		return new EMA($period);
	}
}
