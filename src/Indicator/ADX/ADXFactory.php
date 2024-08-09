<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\ADX;

use Kensho\Chart\Indicator\WSMA\WSMA;

final readonly class ADXFactory implements ADXFactoryInterface
{
    public static function create(int $period): ADXInterface
    {
        $WSMA = new WSMA(period: $period);

        return new ADX(WSMA: $WSMA);
    }
}
