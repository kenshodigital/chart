<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Trend;

use Kensho\Indicators\Indicator\DIx\DIxInterface;
use Kensho\Indicators\Indicator\DX\DXInterface;
use Kensho\Indicators\Indicator\EMA\EMAInterface;
use Kensho\Indicators\Indicator\SMA\SMAInterface;
use Kensho\Indicators\Indicator\WSMA\WSMAInterface;
use Kensho\Indicators\Utility\DataPoint;

final readonly class Trend implements TrendInterface
{
    public function __construct(
        private SMAInterface  $SMA,
        private EMAInterface  $EMA,
        private WSMAInterface $DMpSMA,
        private WSMAInterface $DMmSMA,
        private WSMAInterface $ATR,
        private DIxInterface  $DIx,
        private DXInterface   $DX,
        private WSMAInterface $ADX,
    ) {}

    public function calculate(DataPoint $dataPoint): TrendResult
    {
        $candle = $dataPoint->candle;
        $close  = $candle->close;
        $SMA    = $this->SMA->calculate($close);
        $EMA    = $this->EMA->calculate($close);
        $DMp    = $dataPoint->DMp;
        $DMm    = $dataPoint->DMm;
        $TR     = $dataPoint->TR;
        $DMpSMA = $this->DMpSMA->calculate($DMp);
        $DMmSMA = $this->DMmSMA->calculate($DMm);
        $ATR    = $this->ATR->calculate($TR);
        $DIp    = null;
        $DIm    = null;
        $ADX    = null;

        if ($DMpSMA !== null && $DMmSMA !== null && $ATR !== null) {
            $DIp = $this->DIx::calculate($DMpSMA, $ATR);
            $DIm = $this->DIx::calculate($DMmSMA, $ATR);
            $DX  = $this->DX::calculate($DIp, $DIm);
            $ADX = $this->ADX->calculate($DX);
        }
        return new TrendResult($SMA, $EMA, $DIp, $DIm, $ADX);
    }
}