<?php declare(strict_types=1);

namespace Kensho\Indicators\Chart;

use Kensho\Indicators\Candle\CandleFactory;
use Kensho\Indicators\Candle\CandleFactoryInterface;
use Kensho\Indicators\Indicator\ADX\ADXFactory;
use Kensho\Indicators\Indicator\ADX\ADXFactoryInterface;
use Kensho\Indicators\Indicator\DI\DIFactory;
use Kensho\Indicators\Indicator\DI\DIFactoryInterface;
use Kensho\Indicators\Indicator\EMA\EMAFactory;
use Kensho\Indicators\Indicator\EMA\EMAFactoryInterface;
use Kensho\Indicators\Indicator\SMA\SMAFactory;
use Kensho\Indicators\Indicator\SMA\SMAFactoryInterface;

final readonly class ChartFactory implements ChartFactoryInterface
{
    public static function bootstrap(array $data): Chart
    {
        return (new ChartFactory(
            new CandleFactory,
            new SMAFactory,
            new EMAFactory,
            new DIFactory,
            new ADXFactory,
        ))->create($data);
    }

    public function __construct(
        private CandleFactoryInterface $candleFactory,
        private SMAFactoryInterface    $SMAFactory,
        private EMAFactoryInterface    $EMAFactory,
        private DIFactoryInterface     $DIFactory,
        private ADXFactoryInterface    $ADXFactory,
    ) {}

    public function create(array $data): Chart
    {
        $previous = null;
        $candles  = [];

        foreach ($data as $date => [
            'open'   => $open,
            'high'   => $high,
            'low'    => $low,
            'close'  => $close,
            'volume' => $volume,
        ]) {
            $candles[$date] = $this->candleFactory::create($open, $high, $low, $close, $volume, $previous);
            $previous       = $candles[$date];
        }
        return new Chart(
            $candles,
            $this->SMAFactory,
            $this->EMAFactory,
            $this->DIFactory,
            $this->ADXFactory,
        );
    }
}
