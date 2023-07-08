<?php declare(strict_types=1);

namespace Kensho\TechnicalIndicators\Chart;

use Kensho\TechnicalIndicators\Candle;
use Kensho\TechnicalIndicators\DataPoint;
use Kensho\TechnicalIndicators\DMm\DMmInterface;
use Kensho\TechnicalIndicators\DMp\DMpInterface;
use Kensho\TechnicalIndicators\MoveDown\MoveDownInterface;
use Kensho\TechnicalIndicators\MoveUp\MoveUpInterface;
use Kensho\TechnicalIndicators\TR\TRInterface;

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
