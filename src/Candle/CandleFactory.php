<?php declare(strict_types=1);

namespace Kensho\Chart\Candle;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\Exception\MathException;

final readonly class CandleFactory implements CandleFactoryInterface
{
    /**
     * @throws MathException
     */
    public static function create(
        string      $open,
        string      $high,
        string      $low,
        string      $close,
        string      $volume,
        Candle|null $previous,
    ): Candle {
        $open    = BigDecimal::of($open);
        $high    = BigDecimal::of($high);
        $low     = BigDecimal::of($low);
        $close   = BigDecimal::of($close);
        $volume  = BigInteger::of($volume);
        $highLow = $high->minus($low);
        $TR      = $highLow;
        $DMp     = BigDecimal::zero();
        $DMm     = BigDecimal::zero();

        if ($previous !== null) {

            /*
             * Calculates true range (TR).
             */

            $highClose     = $high->minus($previous->close);
            $absHighClose  = $highClose->abs();
            $lowClose      = $low->minus($previous->close);
            $absLowClose   = $lowClose->abs();
            $TR            = BigDecimal::max($highLow, $absHighClose, $absLowClose);

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
