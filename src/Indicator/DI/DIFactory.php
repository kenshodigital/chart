<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Kensho\Chart\Indicator\WSMA\WSMA;

final readonly class DIFactory implements DIFactoryInterface
{
    public static function create(int $period): DIInterface
    {
        $DMpSMA = new WSMA(period: $period);
        $DMmSMA = new WSMA(period: $period);
        $ATR    = new WSMA(period: $period);

        return new DI(DMpSMA: $DMpSMA, DMmSMA: $DMmSMA, ATR: $ATR);
    }
}
