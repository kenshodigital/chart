<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use DomainException;
use Kensho\Chart\Indicator\WSMA\WSMA;
use Override;

final readonly class ADXFactory implements ADXFactoryInterface
{
	/**
	 * @throws DomainException
	 */
	#[Override]
	public static function create(int $period): ADXInterface
	{
		return new ADX(new WSMA($period));
	}
}
