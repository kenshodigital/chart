<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

/**
 * @api
 */
interface ADXFactoryInterface
{
	public static function create(int $period): ADXInterface;
}
