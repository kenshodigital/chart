<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

use Kensho\Chart\Indicator\WSMA\WSMA;

final readonly class DIFactory implements DIFactoryInterface
{
    public static function create(int $period): DIInterface
    {
        return new DI(
            new WSMA($period),
            new WSMA($period),
            new WSMA($period),
        );
    }
}
