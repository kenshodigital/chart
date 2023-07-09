<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Chart;

use Kensho\Indicators\Indicator\DMm\DMm;
use Kensho\Indicators\Indicator\DMp\DMp;
use Kensho\Indicators\Indicator\MoveDown\MoveDown;
use Kensho\Indicators\Indicator\MoveUp\MoveUp;
use Kensho\Indicators\Indicator\TR\TR;

final readonly class ChartFactory implements ChartFactoryInterface
{
    public static function create(): Chart
    {
        return new Chart(
            new MoveUp,
            new MoveDown,
            new DMp,
            new DMm,
            new TR,
        );
    }
}
