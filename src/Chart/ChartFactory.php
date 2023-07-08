<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Chart;

use Kensho\TechnicalIndicators\DMm\DMm;
use Kensho\TechnicalIndicators\DMp\DMp;
use Kensho\TechnicalIndicators\MoveDown\MoveDown;
use Kensho\TechnicalIndicators\MoveUp\MoveUp;
use Kensho\TechnicalIndicators\TR\TR;

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
