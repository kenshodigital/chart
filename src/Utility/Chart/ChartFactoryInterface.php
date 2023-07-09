<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Chart;

interface ChartFactoryInterface
{
    public static function create(): Chart;
}
