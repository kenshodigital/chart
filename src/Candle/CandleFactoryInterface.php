<?php declare(strict_types=1);

namespace Kensho\Chart\Candle;

interface CandleFactoryInterface
{
    public static function create(
        string      $open,
        string      $high,
        string      $low,
        string      $close,
        string      $volume,
        Candle|null $previous,
    ): Candle;
}
