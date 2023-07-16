<?php declare(strict_types=1);

namespace Kensho\Chart\Chart;

use Kensho\Chart\DI;
use Kensho\Chart\Trend;

/**
 * Calculate indicators for technical chart analysis.
 */
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
