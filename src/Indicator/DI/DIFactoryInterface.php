<?php declare(strict_types=1);

namespace Kensho\Chart\Indicator\DI;

interface DIFactoryInterface
{
    public static function create(int $period): DIInterface;
}
