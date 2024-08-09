<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\EMA;

final readonly class EMAFactory implements EMAFactoryInterface
{
    public static function create(int $period): EMAInterface
    {
        return new EMA($period);
    }
}
