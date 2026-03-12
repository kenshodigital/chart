<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

use DomainException;
use Override;

final readonly class SMAFactory implements SMAFactoryInterface
{
	/**
	 * @throws DomainException
	 */
	#[Override]
	public static function create(int $period): SMAInterface
	{
		return new SMA($period);
	}
}
