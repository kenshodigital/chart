<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\SMA;

interface SMAFactoryInterface
{
    public static function create(int $period): SMAInterface;
}
