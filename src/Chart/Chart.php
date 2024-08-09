<?php declare(strict_types=1);

namespace Kensho\Chart\Chart;

use Kensho\Chart\Candle\Candle;
use Kensho\Chart\DI;
use Kensho\Chart\Indicator\ADX\ADXFactoryInterface;
use Kensho\Chart\Indicator\DI\DIFactoryInterface;
use Kensho\Chart\Indicator\EMA\EMAFactoryInterface;
use Kensho\Chart\Indicator\SMA\SMAFactoryInterface;
use Kensho\Chart\Trend;

final readonly class Chart implements ChartInterface
{
    private const int SCALE = 4;

    /**
     * @param array<string, Candle> $candles
     */
    public function __construct(
        private array               $candles,
        private SMAFactoryInterface $SMAFactory,
        private EMAFactoryInterface $EMAFactory,
        private DIFactoryInterface  $DIFactory,
        private ADXFactoryInterface $ADXFactory,
    ) {}

    public function getSMA(int $period): array
    {
        $SMA    = $this->SMAFactory::create(period: $period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $SMAResult     = $SMA->calculate(value: $close);
            $result[$date] = $SMAResult?->round(scale: self::SCALE);
        }
        return $result;
    }

    public function getEMA(int $period): array
    {
        $EMA    = $this->EMAFactory::create(period: $period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $EMAResult     = $EMA->calculate(value: $close);
            $result[$date] = $EMAResult?->round(scale: self::SCALE);
        }
        return $result;
    }

    public function getDI(int $period): array
    {
        $DI     = $this->DIFactory::create(period: $period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $DMp           = $candle->DMp;
            $DMm           = $candle->DMm;
            $TR            = $candle->TR;
            $DIResult      = $DI->calculate(DMp: $DMp, DMm: $DMm, TR: $TR);
            $DIpResult     = $DIResult->DIp;
            $DIpRounded    = $DIpResult?->round(scale: self::SCALE);
            $DImResult     = $DIResult->DIm;
            $DImRounded    = $DImResult?->round(scale: self::SCALE);
            $result[$date] = new DI(DIp: $DIpRounded, DIm: $DImRounded);
        }
        return $result;
    }

    public function getADX(int $period): array
    {
        $DI     = $this->DIFactory::create(period: $period);
        $ADX    = $this->ADXFactory::create(period: $period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $DMp       = $candle->DMp;
            $DMm       = $candle->DMm;
            $TR        = $candle->TR;
            $DIResult  = $DI->calculate(DMp: $DMp, DMm: $DMm, TR: $TR);
            $DIpResult = $DIResult->DIp;
            $DImResult = $DIResult->DIm;

            if ($DIpResult !== null && $DImResult !== null) {
                $ADXResult     = $ADX->calculate(DIp: $DIpResult, DIm: $DImResult);
                $result[$date] = $ADXResult?->round(scale: self::SCALE);
            } else {
                $result[$date] = null;
            }
        }
        return $result;
    }

    public function getTrend(int $SMAPeriod, int $EMAPeriod): array
    {
        $SMA    = $this->SMAFactory::create(period: $SMAPeriod);
        $EMA    = $this->EMAFactory::create(period: $EMAPeriod);
        $DI     = $this->DIFactory::create(period: $EMAPeriod);
        $ADX    = $this->ADXFactory::create(period: $EMAPeriod);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close        = $candle->close;
            $closeRounded = $close->round(scale: self::SCALE);
            $SMAResult    = $SMA->calculate(value: $close);
            $SMARounded   = $SMAResult?->round(scale: self::SCALE);
            $EMAResult    = $EMA->calculate(value: $close);
            $EMARounded   = $EMAResult?->round(scale: self::SCALE);
            $DMp          = $candle->DMp;
            $DMm          = $candle->DMm;
            $TR           = $candle->TR;
            $DIResult     = $DI->calculate(DMp: $DMp, DMm: $DMm, TR: $TR);
            $DIpResult    = $DIResult->DIp;
            $DIpRounded   = $DIpResult?->round(scale: self::SCALE);
            $DImResult    = $DIResult->DIm;
            $DImRounded   = $DImResult?->round(scale: self::SCALE);
            $ADXRounded   = null;

            if ($DIpResult !== null && $DImResult !== null) {
                $ADXResult  = $ADX->calculate(DIp: $DIpResult, DIm: $DImResult);
                $ADXRounded = $ADXResult?->round(scale: self::SCALE);
            }

            $result[$date] = new Trend(
                close: $closeRounded,
                SMA:   $SMARounded,
                EMA:   $EMARounded,
                DIp:   $DIpRounded,
                DIm:   $DImRounded,
                ADX:   $ADXRounded,
            );
        }
        return $result;
    }
}
