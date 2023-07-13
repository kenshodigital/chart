<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\SMA;

final readonly class SMAFactory implements SMAFactoryInterface
{
    public static function create(int $period): SMAInterface
    {
        return new SMA($period);
    }
}
