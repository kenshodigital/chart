<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Chart;

interface ChartFactoryInterface
{
    public static function create(): Chart;
}
