<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

interface ADXFactoryInterface
{
    public static function create(int $period): ADXInterface;
}
