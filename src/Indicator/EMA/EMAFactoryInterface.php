<?php

declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

/**
 * @api
 */
interface EMAFactoryInterface
{
	public static function create(int $period): EMAInterface;
}
