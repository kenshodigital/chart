<?php declare(strict_types=1);

namespace Kensho\Indicators\Chart;

use Kensho\Indicators\DI;
use Kensho\Indicators\Trend;

interface ChartInterface
{
    /**
     * @return array<string, string|null>
     */
    public function getSMA(int $period): array;

    /**
     * @return array<string, string|null>
     */
    public function getEMA(int $period): array;

    /**
     * @return array<string, DI>
     */
    public function getDI(int $period): array;

    /**
     * @return array<string, string|null>
     */
    public function getADX(int $period): array;

    /**
     * @return array<string, Trend>
     */
    public function getTrend(int $SMAPeriod, int $EMAPeriod): array;
}
