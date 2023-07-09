<?php declare(strict_types=1);

namespace Kensho\Indicators\Utility\Chart;

use Kensho\Indicators\Indicator\DMm\DMmInterface;
use Kensho\Indicators\Indicator\DMp\DMpInterface;
use Kensho\Indicators\Indicator\MoveDown\MoveDownInterface;
use Kensho\Indicators\Indicator\MoveUp\MoveUpInterface;
use Kensho\Indicators\Indicator\TR\TRInterface;
use Kensho\Indicators\Utility\Candle;
use Kensho\Indicators\Utility\DataPoint;

final readonly class Chart implements ChartInterface
{
    public function __construct(
        private MoveUpInterface   $moveUp,
        private MoveDownInterface $moveDown,
        private DMpInterface      $DMp,
        private DMmInterface      $DMm,
        private TRInterface       $TR,
    ) {}

    public function calculate(Candle $candle): DataPoint
    {
        $high     = $candle->high;
        $moveUp   = $this->moveUp->calculate($high);
        $low      = $candle->low;
        $moveDown = $this->moveDown->calculate($low);
        $DMp      = $this->DMp::calculate($moveUp, $moveDown);
        $DMm      = $this->DMm::calculate($moveDown, $moveUp);
        $close    = $candle->close;
        $TR       = $this->TR->calculate($high, $low, $close);

        return new DataPoint($candle, $DMp, $DMm, $TR);
    }
}
