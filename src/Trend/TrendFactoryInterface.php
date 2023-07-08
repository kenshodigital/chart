<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Trend;

interface TrendFactoryInterface
{
    public static function create(int $SMAPeriod, int $EMAPeriod): TrendInterface;
}
