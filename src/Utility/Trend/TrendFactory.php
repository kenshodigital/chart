<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Trend;

use Brick\Math\Exception\MathException;
use Kensho\Indicators\Indicator\DIx\DIx;
use Kensho\Indicators\Indicator\DX\DX;
use Kensho\Indicators\Indicator\EMA\EMA;
use Kensho\Indicators\Indicator\SMA\SMA;
use Kensho\Indicators\Indicator\WSMA\WSMA;

final readonly class TrendFactory implements TrendFactoryInterface
{
    /**
     * @throws MathException
     */
    public static function create(int $SMAPeriod, int $EMAPeriod): TrendInterface
    {
        return new Trend(
            new SMA($SMAPeriod),
            new EMA($EMAPeriod),
            new WSMA($EMAPeriod),
            new WSMA($EMAPeriod),
            new WSMA($EMAPeriod),
            new DIx,
            new DX,
            new WSMA($EMAPeriod),
        );
    }
}
