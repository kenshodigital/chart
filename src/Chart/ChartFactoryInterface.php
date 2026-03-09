<?php declare(strict_types=1);

namespace Kensho\Chart\Chart;

/**
 * Creates a chart from the given data to
 * calculate indicators for technical analysis.
 *
 * @api
 */
interface ChartFactoryInterface
{
	/**
	 * @param array<string, array{open: string, high: string, low: string, close: string, volume: string}> $data
	 */
	public static function bootstrap(array $data): Chart;

	/**
	 * @param array<string, array{open: string, high: string, low: string, close: string, volume: string}> $data
	 */
	public function create(array $data): Chart;
}
