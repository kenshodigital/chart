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
    private const SCALE = 4;

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
        $SMA    = $this->SMAFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $SMAResult     = $SMA->calculate($close);
            $result[$date] = $SMAResult?->round(self::SCALE);
        }
        return $result;
    }

    public function getEMA(int $period): array
    {
        $EMA    = $this->EMAFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $EMAResult     = $EMA->calculate($close);
            $result[$date] = $EMAResult?->round(self::SCALE);
        }
        return $result;
    }

    public function getDI(int $period): array
    {
        $DI     = $this->DIFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $DMp           = $candle->DMp;
            $DMm           = $candle->DMm;
            $TR            = $candle->TR;
            $DIResult      = $DI->calculate($DMp, $DMm, $TR);
            $DIpResult     = $DIResult->DIp;
            $DIpRounded    = $DIpResult?->round(self::SCALE);
            $DImResult     = $DIResult->DIm;
            $DImRounded    = $DImResult?->round(self::SCALE);
            $result[$date] = new DI($DIpRounded, $DImRounded);
        }
        return $result;
    }

    public function getADX(int $period): array
    {
        $DI     = $this->DIFactory::create($period);
        $ADX    = $this->ADXFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $DMp       = $candle->DMp;
            $DMm       = $candle->DMm;
            $TR        = $candle->TR;
            $DIResult  = $DI->calculate($DMp, $DMm, $TR);
            $DIpResult = $DIResult->DIp;
            $DImResult = $DIResult->DIm;

            if ($DIpResult !== null && $DImResult !== null) {
                $ADXResult     = $ADX->calculate($DIpResult, $DImResult);
                $result[$date] = $ADXResult?->round(self::SCALE);
            } else {
                $result[$date] = null;
            }
        }
        return $result;
    }

    public function getTrend(int $SMAPeriod, int $EMAPeriod): array
    {
        $SMA    = $this->SMAFactory::create($SMAPeriod);
        $EMA    = $this->EMAFactory::create($EMAPeriod);
        $DI     = $this->DIFactory::create($EMAPeriod);
        $ADX    = $this->ADXFactory::create($EMAPeriod);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close        = $candle->close;
            $closeRounded = $close->round(self::SCALE);
            $SMAResult    = $SMA->calculate($close);
            $SMARounded   = $SMAResult?->round(self::SCALE);
            $EMAResult    = $EMA->calculate($close);
            $EMARounded   = $EMAResult?->round(self::SCALE);
            $DMp          = $candle->DMp;
            $DMm          = $candle->DMm;
            $TR           = $candle->TR;
            $DIResult     = $DI->calculate($DMp, $DMm, $TR);
            $DIpResult    = $DIResult->DIp;
            $DIpRounded   = $DIpResult?->round(self::SCALE);
            $DImResult    = $DIResult->DIm;
            $DImRounded   = $DImResult?->round(self::SCALE);
            $ADXRounded   = null;

            if ($DIpResult !== null && $DImResult !== null) {
                $ADXResult  = $ADX->calculate($DIpResult, $DImResult);
                $ADXRounded = $ADXResult?->round(self::SCALE);
            }

            $result[$date] = new Trend(
                $closeRounded,
                $SMARounded,
                $EMARounded,
                $DIpRounded,
                $DImRounded,
                $ADXRounded,
            );
        }
        return $result;
    }
}
