<?php declare(strict_types=1);

namespace Kensho\Indicators\Chart;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Math\RoundingMode;
use Kensho\Indicators\Candle\Candle;
use Kensho\Indicators\DI;
use Kensho\Indicators\Indicator\ADX\ADXFactoryInterface;
use Kensho\Indicators\Indicator\DI\DIFactoryInterface;
use Kensho\Indicators\Indicator\EMA\EMAFactoryInterface;
use Kensho\Indicators\Indicator\SMA\SMAFactoryInterface;
use Kensho\Indicators\Trend;

final readonly class Chart implements ChartInterface
{
    private const ROUNDING_MODE = RoundingMode::HALF_UP;
    private const SCALE         = 4;

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

    /**
     * @throws RoundingNecessaryException
     */
    public function getSMA(int $period): array
    {
        $SMA    = $this->SMAFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $SMAResult     = $SMA->calculate($close);
            $result[$date] = $this->round($SMAResult);
        }
        return $result;
    }

    /**
     * @throws RoundingNecessaryException
     */
    public function getEMA(int $period): array
    {
        $EMA    = $this->EMAFactory::create($period);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close         = $candle->close;
            $EMAResult     = $EMA->calculate($close);
            $result[$date] = $this->round($EMAResult);
        }
        return $result;
    }

    /**
     * @throws RoundingNecessaryException
     */
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
            $DIpRounded    = $this->round($DIpResult);
            $DImResult     = $DIResult->DIm;
            $DImRounded    = $this->round($DImResult);
            $result[$date] = new DI($DIpRounded, $DImRounded);
        }
        return $result;
    }

    /**
     * @throws RoundingNecessaryException
     */
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
                $result[$date] = $this->round($ADXResult);
            } else {
                $result[$date] = null;
            }
        }
        return $result;
    }

    /**
     * @throws RoundingNecessaryException
     */
    public function getTrend(int $SMAPeriod, int $EMAPeriod): array
    {
        $SMA    = $this->SMAFactory::create($SMAPeriod);
        $EMA    = $this->EMAFactory::create($EMAPeriod);
        $DI     = $this->DIFactory::create($EMAPeriod);
        $ADX    = $this->ADXFactory::create($EMAPeriod);
        $result = [];

        foreach ($this->candles as $date => $candle) {
            $close      = $candle->close;
            $SMAResult  = $SMA->calculate($close);
            $SMARounded = $this->round($SMAResult);
            $EMAResult  = $EMA->calculate($close);
            $EMARounded = $this->round($EMAResult);
            $DMp        = $candle->DMp;
            $DMm        = $candle->DMm;
            $TR         = $candle->TR;
            $DIResult   = $DI->calculate($DMp, $DMm, $TR);
            $DIpResult  = $DIResult->DIp;
            $DIpRounded = $this->round($DIpResult);
            $DImResult  = $DIResult->DIm;
            $DImRounded = $this->round($DImResult);
            $ADXRounded = null;

            if ($DIpResult !== null && $DImResult !== null) {
                $ADXResult  = $ADX->calculate($DIpResult, $DImResult);
                $ADXRounded = $this->round($ADXResult);
            }

            $result[$date] = new Trend(
                $SMARounded,
                $EMARounded,
                $DIpRounded,
                $DImRounded,
                $ADXRounded,
            );
        }
        return $result;
    }

    /**
     * @throws RoundingNecessaryException
     */
    private function round(BigDecimal|null $value): string|null
    {
        return $value?->toScale(self::SCALE, self::ROUNDING_MODE)->__toString();
    }
}
