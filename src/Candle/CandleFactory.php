<?php declare(strict_types=1);

namespace Kensho\Chart\Candle;

use Kensho\Chart\Number;

final readonly class CandleFactory implements CandleFactoryInterface
{
    public static function create(
        string      $open,
        string      $high,
        string      $low,
        string      $close,
        string      $volume,
        Candle|null $previous,
    ): Candle {
        $open    = new Number(value: $open);
        $high    = new Number(value: $high);
        $low     = new Number(value: $low);
        $close   = new Number(value: $close);
        $volume  = new Number(value: $volume);
        $highLow = $high->minus(value: $low);
        $TR      = $highLow;
        $DMp     = new Number(value: 0);
        $DMm     = new Number(value: 0);

        if ($previous !== null) {

            /*
             * Calculates true range (TR).
             */

            $highClose    = $high->minus(value: $previous->close);
            $absHighClose = $highClose->abs();
            $lowClose     = $low->minus(value: $previous->close);
            $absLowClose  = $lowClose->abs();

            if ($absHighClose->isGreaterThan(value: $TR)) {
                $TR = $absHighClose;
            }
            if ($absLowClose->isGreaterThan(value: $TR)) {
                $TR = $absLowClose;
            }

            /*
             * Calculates directional movements (+DM & -DM).
             */

            $upMove   = $high->minus(value: $previous->high);
            $downMove = $previous->low->minus(value: $low);

            if ($upMove->isPositive() && $upMove->isGreaterThan(value: $downMove)) {
                $DMp = $upMove;
            }
            if ($downMove->isPositive() && $downMove->isGreaterThan(value: $upMove)) {
                $DMm = $downMove;
            }
        }
        return new Candle(
            open:   $open,
            high:   $high,
            low:    $low,
            close:  $close,
            volume: $volume,
            TR:     $TR,
            DMp:    $DMp,
            DMm:    $DMm,
        );
    }
}
