<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

interface EMAFactoryInterface
{
    public static function create(int $period): EMAInterface;
}
