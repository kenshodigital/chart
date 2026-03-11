<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

/**
 * @api
 */
interface SMAFactoryInterface
{
	public static function create(int $period): SMAInterface;
}
