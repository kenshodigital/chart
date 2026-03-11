<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

use DomainException;

final readonly class SMAFactory implements SMAFactoryInterface
{
	/**
	 * @throws DomainException
	 */
	public static function create(int $period): SMAInterface
	{
		return new SMA($period);
	}
}
