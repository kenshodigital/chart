<?php declare(strict_types=1);

namespace Kensho\Indicators\Chart;

interface ChartFactoryInterface
{
    /**
     * @param array<string, array<string, string>> $data
     */
    public static function bootstrap(array $data): Chart;

    /**
     * @param array<string, array<string, string>> $data
     */
    public function create(array $data): Chart;
}
