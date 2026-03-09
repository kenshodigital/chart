<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use DomainException;
use Kensho\Chart\Indicator\WSMA\WSMA;

final readonly class ADXFactory implements ADXFactoryInterface
{
	/**
	 * @throws DomainException
	 */
	public static function create(int $period): ADXInterface
	{
		return new ADX(new WSMA($period));
	}
}
