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
        $open    = new Number($open);
        $high    = new Number($high);
        $low     = new Number($low);
        $close   = new Number($close);
        $volume  = new Number($volume);
        $highLow = $high->minus($low);
        $TR      = $highLow;
        $DMp     = new Number(0);
        $DMm     = new Number(0);

        if ($previous !== null) {

            /*
             * Calculates true range (TR).
             */

            $highClose    = $high->minus($previous->close);
            $absHighClose = $highClose->abs();
            $lowClose     = $low->minus($previous->close);
            $absLowClose  = $lowClose->abs();

            if ($absHighClose->isGreaterThan($TR)) {
                $TR = $absHighClose;
            }
            if ($absLowClose->isGreaterThan($TR)) {
                $TR = $absLowClose;
            }

            /*
             * Calculates directional movements (+DM & -DM).
             */

            $upMove   = $high->minus($previous->high);
            $downMove = $previous->low->minus($low);

            if ($upMove->isPositive() && $upMove->isGreaterThan($downMove)) {
                $DMp = $upMove;
            }
            if ($downMove->isPositive() && $downMove->isGreaterThan($upMove)) {
                $DMm = $downMove;
            }
        }
        return new Candle(
            $open,
            $high,
            $low,
            $close,
            $volume,
            $TR,
            $DMp,
            $DMm,
        );
    }
}
