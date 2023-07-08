<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Trend;

use Brick\Math\Exception\MathException;
use Kensho\TechnicalIndicators\DIx\DIx;
use Kensho\TechnicalIndicators\DX\DX;
use Kensho\TechnicalIndicators\EMA\EMA;
use Kensho\TechnicalIndicators\SMA\SMA;
use Kensho\TechnicalIndicators\WSMA\WSMA;

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
