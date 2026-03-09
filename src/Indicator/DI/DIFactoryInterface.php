<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

/**
 * @api
 */
interface DIFactoryInterface
{
	public static function create(int $period): DIInterface;
}
