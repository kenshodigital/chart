<?php declare(strict_types=1);

namespace Kensho\Indicators\Indicator\EMA;

use Brick\Math\Exception\MathException;

final readonly class EMAFactory implements EMAFactoryInterface
{
    /**
     * @throws MathException
     */
    public static function create(int $period): EMAInterface
    {
        return new EMA($period);
    }
}
