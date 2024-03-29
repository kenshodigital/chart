<?php declare(strict_types=1);

namespace Kensho\Chart\Tests\Unit\Indicator;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\MathException;
use Brick\Math\RoundingMode;
use DomainException;
use Kensho\Chart\Indicator\WSMA\WSMA;
use Kensho\Chart\Indicator\WSMA\WSMAInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class WSMATest extends TestCase
{
    #[DataProvider('provideInvalidPeriod')]
    public function testInvalidPeriod(int $period): void
    {
        $this->expectException(DomainException::class);

        $actual = new WSMA($period);

        $this->assertInstanceOf(WSMAInterface::class, $actual);
    }

    /**
     * @param array<string, string>      $values
     * @param array<string, string|null> $expected
     *
     * @throws MathException
     */
    #[DataProvider('provideData')]
    public function testCalculate(int $period, array $values, array $expected): void
    {
        $instance = new WSMA($period);
        $actual   = [];

        foreach ($values as $date => $value) {
            $actual[$date] = $instance->calculate(
                BigDecimal::of($value),
            )?->toScale(
                4,
                RoundingMode::HALF_UP,
            )->__toString();
        }
        $this->assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<string, int>>
     */
    public static function provideInvalidPeriod(): array
    {
        return [
            'Period negative'  => [ 'period' => -1 ],
            'Period zero'      => [ 'period' =>  0 ],
            'Period too short' => [ 'period' =>  1 ],
        ];
    }

    /**
     * @return array<string, array<string, int|array<string, string|null>>>
     */
    public static function provideData(): array
    {
        return [
            'WSMA 2 days'   => [
                'period'   => 2,
                'values'   => [
                    '2023-01-25' => '141.8600',
                    '2023-01-26' => '143.9600',
                    '2023-01-27' => '145.9300',
                    '2023-01-30' => '143.0000',
                    '2023-01-31' => '144.2900',
                    '2023-02-01' => '145.4300',
                    '2023-02-02' => '150.8200',
                    '2023-02-03' => '154.5000',
                    '2023-02-06' => '151.7300',
                    '2023-02-07' => '154.6500',
                    '2023-02-08' => '151.9200',
                    '2023-02-09' => '150.8700',
                    '2023-02-10' => '151.0100',
                    '2023-02-13' => '153.8500',
                    '2023-02-14' => '153.2000',
                    '2023-02-15' => '155.3300',
                    '2023-02-16' => '153.7100',
                    '2023-02-17' => '152.5500',
                    '2023-02-21' => '148.4800',
                    '2023-02-22' => '148.9100',
                    '2023-02-23' => '149.4000',
                    '2023-02-24' => '146.7100',
                    '2023-02-27' => '147.9200',
                    '2023-02-28' => '147.4100',
                    '2023-03-01' => '145.3100',
                    '2023-03-02' => '145.9100',
                    '2023-03-03' => '151.0300',
                    '2023-03-06' => '153.8300',
                    '2023-03-07' => '151.6000',
                    '2023-03-08' => '152.8700',
                    '2023-03-09' => '150.5900',
                    '2023-03-10' => '148.5000',
                    '2023-03-13' => '150.4700',
                    '2023-03-14' => '152.5900',
                    '2023-03-15' => '152.9900',
                    '2023-03-16' => '155.8500',
                    '2023-03-17' => '155.0000',
                    '2023-03-20' => '157.4000',
                    '2023-03-21' => '159.2800',
                    '2023-03-22' => '157.8300',
                    '2023-03-23' => '158.9300',
                    '2023-03-24' => '160.2500',
                    '2023-03-27' => '158.2800',
                    '2023-03-28' => '157.6500',
                    '2023-03-29' => '160.7700',
                    '2023-03-30' => '162.3600',
                    '2023-03-31' => '164.9000',
                    '2023-04-03' => '166.1700',
                    '2023-04-04' => '165.6300',
                    '2023-04-05' => '163.7600',
                    '2023-04-06' => '164.6600',
                    '2023-04-10' => '162.0300',
                    '2023-04-11' => '160.8000',
                    '2023-04-12' => '160.1000',
                    '2023-04-13' => '165.5600',
                    '2023-04-14' => '165.2100',
                    '2023-04-17' => '165.2300',
                    '2023-04-18' => '166.4700',
                    '2023-04-19' => '167.6300',
                    '2023-04-20' => '166.6500',
                    '2023-04-21' => '165.0200',
                    '2023-04-24' => '165.3300',
                    '2023-04-25' => '163.7700',
                    '2023-04-26' => '163.7600',
                    '2023-04-27' => '168.4100',
                    '2023-04-28' => '169.6800',
                    '2023-05-01' => '169.5900',
                    '2023-05-02' => '168.5400',
                    '2023-05-03' => '167.4500',
                    '2023-05-04' => '165.7900',
                    '2023-05-05' => '173.5700',
                    '2023-05-08' => '173.5000',
                    '2023-05-09' => '171.7700',
                    '2023-05-10' => '173.5550',
                    '2023-05-11' => '173.7500',
                    '2023-05-12' => '172.5700',
                    '2023-05-15' => '172.0700',
                    '2023-05-16' => '172.0700',
                    '2023-05-17' => '172.6900',
                    '2023-05-18' => '175.0500',
                    '2023-05-19' => '175.1600',
                    '2023-05-22' => '174.2000',
                    '2023-05-23' => '171.5600',
                    '2023-05-24' => '171.8400',
                    '2023-05-25' => '172.9900',
                    '2023-05-26' => '175.4300',
                    '2023-05-30' => '177.3000',
                    '2023-05-31' => '177.2500',
                    '2023-06-01' => '180.0900',
                    '2023-06-02' => '180.9500',
                    '2023-06-05' => '179.5800',
                    '2023-06-06' => '179.2100',
                    '2023-06-07' => '177.8200',
                    '2023-06-08' => '180.5700',
                    '2023-06-09' => '180.9600',
                    '2023-06-12' => '183.7900',
                    '2023-06-13' => '183.3100',
                    '2023-06-14' => '183.9500',
                    '2023-06-15' => '186.0100',
                    '2023-06-16' => '184.9200',
                ],
                'expected' => [
                    '2023-01-25' => null,
                    '2023-01-26' => '142.9100',
                    '2023-01-27' => '144.4200',
                    '2023-01-30' => '143.7100',
                    '2023-01-31' => '144.0000',
                    '2023-02-01' => '144.7150',
                    '2023-02-02' => '147.7675',
                    '2023-02-03' => '151.1338',
                    '2023-02-06' => '151.4319',
                    '2023-02-07' => '153.0409',
                    '2023-02-08' => '152.4805',
                    '2023-02-09' => '151.6752',
                    '2023-02-10' => '151.3426',
                    '2023-02-13' => '152.5963',
                    '2023-02-14' => '152.8982',
                    '2023-02-15' => '154.1141',
                    '2023-02-16' => '153.9120',
                    '2023-02-17' => '153.2310',
                    '2023-02-21' => '150.8555',
                    '2023-02-22' => '149.8828',
                    '2023-02-23' => '149.6414',
                    '2023-02-24' => '148.1757',
                    '2023-02-27' => '148.0478',
                    '2023-02-28' => '147.7289',
                    '2023-03-01' => '146.5195',
                    '2023-03-02' => '146.2147',
                    '2023-03-03' => '148.6224',
                    '2023-03-06' => '151.2262',
                    '2023-03-07' => '151.4131',
                    '2023-03-08' => '152.1415',
                    '2023-03-09' => '151.3658',
                    '2023-03-10' => '149.9329',
                    '2023-03-13' => '150.2014',
                    '2023-03-14' => '151.3957',
                    '2023-03-15' => '152.1929',
                    '2023-03-16' => '154.0214',
                    '2023-03-17' => '154.5107',
                    '2023-03-20' => '155.9554',
                    '2023-03-21' => '157.6177',
                    '2023-03-22' => '157.7238',
                    '2023-03-23' => '158.3269',
                    '2023-03-24' => '159.2885',
                    '2023-03-27' => '158.7842',
                    '2023-03-28' => '158.2171',
                    '2023-03-29' => '159.4936',
                    '2023-03-30' => '160.9268',
                    '2023-03-31' => '162.9134',
                    '2023-04-03' => '164.5417',
                    '2023-04-04' => '165.0858',
                    '2023-04-05' => '164.4229',
                    '2023-04-06' => '164.5415',
                    '2023-04-10' => '163.2857',
                    '2023-04-11' => '162.0429',
                    '2023-04-12' => '161.0714',
                    '2023-04-13' => '163.3157',
                    '2023-04-14' => '164.2629',
                    '2023-04-17' => '164.7464',
                    '2023-04-18' => '165.6082',
                    '2023-04-19' => '166.6191',
                    '2023-04-20' => '166.6346',
                    '2023-04-21' => '165.8273',
                    '2023-04-24' => '165.5786',
                    '2023-04-25' => '164.6743',
                    '2023-04-26' => '164.2172',
                    '2023-04-27' => '166.3136',
                    '2023-04-28' => '167.9968',
                    '2023-05-01' => '168.7934',
                    '2023-05-02' => '168.6667',
                    '2023-05-03' => '168.0583',
                    '2023-05-04' => '166.9242',
                    '2023-05-05' => '170.2471',
                    '2023-05-08' => '171.8735',
                    '2023-05-09' => '171.8218',
                    '2023-05-10' => '172.6884',
                    '2023-05-11' => '173.2192',
                    '2023-05-12' => '172.8946',
                    '2023-05-15' => '172.4823',
                    '2023-05-16' => '172.2761',
                    '2023-05-17' => '172.4831',
                    '2023-05-18' => '173.7665',
                    '2023-05-19' => '174.4633',
                    '2023-05-22' => '174.3316',
                    '2023-05-23' => '172.9458',
                    '2023-05-24' => '172.3929',
                    '2023-05-25' => '172.6915',
                    '2023-05-26' => '174.0607',
                    '2023-05-30' => '175.6804',
                    '2023-05-31' => '176.4652',
                    '2023-06-01' => '178.2776',
                    '2023-06-02' => '179.6138',
                    '2023-06-05' => '179.5969',
                    '2023-06-06' => '179.4034',
                    '2023-06-07' => '178.6117',
                    '2023-06-08' => '179.5909',
                    '2023-06-09' => '180.2754',
                    '2023-06-12' => '182.0327',
                    '2023-06-13' => '182.6714',
                    '2023-06-14' => '183.3107',
                    '2023-06-15' => '184.6603',
                    '2023-06-16' => '184.7902',
                ],
            ],
            'WSMA 21 days'  => [
                'period'   => 21,
                'values'   => [
                    '2023-01-25' => '141.8600',
                    '2023-01-26' => '143.9600',
                    '2023-01-27' => '145.9300',
                    '2023-01-30' => '143.0000',
                    '2023-01-31' => '144.2900',
                    '2023-02-01' => '145.4300',
                    '2023-02-02' => '150.8200',
                    '2023-02-03' => '154.5000',
                    '2023-02-06' => '151.7300',
                    '2023-02-07' => '154.6500',
                    '2023-02-08' => '151.9200',
                    '2023-02-09' => '150.8700',
                    '2023-02-10' => '151.0100',
                    '2023-02-13' => '153.8500',
                    '2023-02-14' => '153.2000',
                    '2023-02-15' => '155.3300',
                    '2023-02-16' => '153.7100',
                    '2023-02-17' => '152.5500',
                    '2023-02-21' => '148.4800',
                    '2023-02-22' => '148.9100',
                    '2023-02-23' => '149.4000',
                    '2023-02-24' => '146.7100',
                    '2023-02-27' => '147.9200',
                    '2023-02-28' => '147.4100',
                    '2023-03-01' => '145.3100',
                    '2023-03-02' => '145.9100',
                    '2023-03-03' => '151.0300',
                    '2023-03-06' => '153.8300',
                    '2023-03-07' => '151.6000',
                    '2023-03-08' => '152.8700',
                    '2023-03-09' => '150.5900',
                    '2023-03-10' => '148.5000',
                    '2023-03-13' => '150.4700',
                    '2023-03-14' => '152.5900',
                    '2023-03-15' => '152.9900',
                    '2023-03-16' => '155.8500',
                    '2023-03-17' => '155.0000',
                    '2023-03-20' => '157.4000',
                    '2023-03-21' => '159.2800',
                    '2023-03-22' => '157.8300',
                    '2023-03-23' => '158.9300',
                    '2023-03-24' => '160.2500',
                    '2023-03-27' => '158.2800',
                    '2023-03-28' => '157.6500',
                    '2023-03-29' => '160.7700',
                    '2023-03-30' => '162.3600',
                    '2023-03-31' => '164.9000',
                    '2023-04-03' => '166.1700',
                    '2023-04-04' => '165.6300',
                    '2023-04-05' => '163.7600',
                    '2023-04-06' => '164.6600',
                    '2023-04-10' => '162.0300',
                    '2023-04-11' => '160.8000',
                    '2023-04-12' => '160.1000',
                    '2023-04-13' => '165.5600',
                    '2023-04-14' => '165.2100',
                    '2023-04-17' => '165.2300',
                    '2023-04-18' => '166.4700',
                    '2023-04-19' => '167.6300',
                    '2023-04-20' => '166.6500',
                    '2023-04-21' => '165.0200',
                    '2023-04-24' => '165.3300',
                    '2023-04-25' => '163.7700',
                    '2023-04-26' => '163.7600',
                    '2023-04-27' => '168.4100',
                    '2023-04-28' => '169.6800',
                    '2023-05-01' => '169.5900',
                    '2023-05-02' => '168.5400',
                    '2023-05-03' => '167.4500',
                    '2023-05-04' => '165.7900',
                    '2023-05-05' => '173.5700',
                    '2023-05-08' => '173.5000',
                    '2023-05-09' => '171.7700',
                    '2023-05-10' => '173.5550',
                    '2023-05-11' => '173.7500',
                    '2023-05-12' => '172.5700',
                    '2023-05-15' => '172.0700',
                    '2023-05-16' => '172.0700',
                    '2023-05-17' => '172.6900',
                    '2023-05-18' => '175.0500',
                    '2023-05-19' => '175.1600',
                    '2023-05-22' => '174.2000',
                    '2023-05-23' => '171.5600',
                    '2023-05-24' => '171.8400',
                    '2023-05-25' => '172.9900',
                    '2023-05-26' => '175.4300',
                    '2023-05-30' => '177.3000',
                    '2023-05-31' => '177.2500',
                    '2023-06-01' => '180.0900',
                    '2023-06-02' => '180.9500',
                    '2023-06-05' => '179.5800',
                    '2023-06-06' => '179.2100',
                    '2023-06-07' => '177.8200',
                    '2023-06-08' => '180.5700',
                    '2023-06-09' => '180.9600',
                    '2023-06-12' => '183.7900',
                    '2023-06-13' => '183.3100',
                    '2023-06-14' => '183.9500',
                    '2023-06-15' => '186.0100',
                    '2023-06-16' => '184.9200',
                ],
                'expected' => [
                    '2023-01-25' => null,
                    '2023-01-26' => null,
                    '2023-01-27' => null,
                    '2023-01-30' => null,
                    '2023-01-31' => null,
                    '2023-02-01' => null,
                    '2023-02-02' => null,
                    '2023-02-03' => null,
                    '2023-02-06' => null,
                    '2023-02-07' => null,
                    '2023-02-08' => null,
                    '2023-02-09' => null,
                    '2023-02-10' => null,
                    '2023-02-13' => null,
                    '2023-02-14' => null,
                    '2023-02-15' => null,
                    '2023-02-16' => null,
                    '2023-02-17' => null,
                    '2023-02-21' => null,
                    '2023-02-22' => null,
                    '2023-02-23' => '149.7810',
                    '2023-02-24' => '149.6347',
                    '2023-02-27' => '149.5531',
                    '2023-02-28' => '149.4510',
                    '2023-03-01' => '149.2538',
                    '2023-03-02' => '149.0946',
                    '2023-03-03' => '149.1868',
                    '2023-03-06' => '149.4079',
                    '2023-03-07' => '149.5122',
                    '2023-03-08' => '149.6721',
                    '2023-03-09' => '149.7158',
                    '2023-03-10' => '149.6580',
                    '2023-03-13' => '149.6966',
                    '2023-03-14' => '149.8344',
                    '2023-03-15' => '149.9847',
                    '2023-03-16' => '150.2640',
                    '2023-03-17' => '150.4895',
                    '2023-03-20' => '150.8186',
                    '2023-03-21' => '151.2215',
                    '2023-03-22' => '151.5362',
                    '2023-03-23' => '151.8883',
                    '2023-03-24' => '152.2864',
                    '2023-03-27' => '152.5719',
                    '2023-03-28' => '152.8137',
                    '2023-03-29' => '153.1925',
                    '2023-03-30' => '153.6291',
                    '2023-03-31' => '154.1658',
                    '2023-04-03' => '154.7374',
                    '2023-04-04' => '155.2561',
                    '2023-04-05' => '155.6611',
                    '2023-04-06' => '156.0896',
                    '2023-04-10' => '156.3725',
                    '2023-04-11' => '156.5833',
                    '2023-04-12' => '156.7508',
                    '2023-04-13' => '157.1702',
                    '2023-04-14' => '157.5531',
                    '2023-04-17' => '157.9187',
                    '2023-04-18' => '158.3259',
                    '2023-04-19' => '158.7689',
                    '2023-04-20' => '159.1442',
                    '2023-04-21' => '159.4240',
                    '2023-04-24' => '159.7052',
                    '2023-04-25' => '159.8988',
                    '2023-04-26' => '160.0827',
                    '2023-04-27' => '160.4792',
                    '2023-04-28' => '160.9173',
                    '2023-05-01' => '161.3303',
                    '2023-05-02' => '161.6736',
                    '2023-05-03' => '161.9487',
                    '2023-05-04' => '162.1316',
                    '2023-05-05' => '162.6763',
                    '2023-05-08' => '163.1917',
                    '2023-05-09' => '163.6002',
                    '2023-05-10' => '164.0743',
                    '2023-05-11' => '164.5350',
                    '2023-05-12' => '164.9176',
                    '2023-05-15' => '165.2582',
                    '2023-05-16' => '165.5826',
                    '2023-05-17' => '165.9210',
                    '2023-05-18' => '166.3557',
                    '2023-05-19' => '166.7750',
                    '2023-05-22' => '167.1286',
                    '2023-05-23' => '167.3396',
                    '2023-05-24' => '167.5539',
                    '2023-05-25' => '167.8128',
                    '2023-05-26' => '168.1755',
                    '2023-05-30' => '168.6100',
                    '2023-05-31' => '169.0214',
                    '2023-06-01' => '169.5485',
                    '2023-06-02' => '170.0914',
                    '2023-06-05' => '170.5433',
                    '2023-06-06' => '170.9560',
                    '2023-06-07' => '171.2828',
                    '2023-06-08' => '171.7251',
                    '2023-06-09' => '172.1648',
                    '2023-06-12' => '172.7184',
                    '2023-06-13' => '173.2228',
                    '2023-06-14' => '173.7336',
                    '2023-06-15' => '174.3182',
                    '2023-06-16' => '174.8230',
                ],
            ],
            'WSMA 73 days'  => [
                'period'   => 73,
                'values'   => [
                    '2023-01-25' => '141.8600',
                    '2023-01-26' => '143.9600',
                    '2023-01-27' => '145.9300',
                    '2023-01-30' => '143.0000',
                    '2023-01-31' => '144.2900',
                    '2023-02-01' => '145.4300',
                    '2023-02-02' => '150.8200',
                    '2023-02-03' => '154.5000',
                    '2023-02-06' => '151.7300',
                    '2023-02-07' => '154.6500',
                    '2023-02-08' => '151.9200',
                    '2023-02-09' => '150.8700',
                    '2023-02-10' => '151.0100',
                    '2023-02-13' => '153.8500',
                    '2023-02-14' => '153.2000',
                    '2023-02-15' => '155.3300',
                    '2023-02-16' => '153.7100',
                    '2023-02-17' => '152.5500',
                    '2023-02-21' => '148.4800',
                    '2023-02-22' => '148.9100',
                    '2023-02-23' => '149.4000',
                    '2023-02-24' => '146.7100',
                    '2023-02-27' => '147.9200',
                    '2023-02-28' => '147.4100',
                    '2023-03-01' => '145.3100',
                    '2023-03-02' => '145.9100',
                    '2023-03-03' => '151.0300',
                    '2023-03-06' => '153.8300',
                    '2023-03-07' => '151.6000',
                    '2023-03-08' => '152.8700',
                    '2023-03-09' => '150.5900',
                    '2023-03-10' => '148.5000',
                    '2023-03-13' => '150.4700',
                    '2023-03-14' => '152.5900',
                    '2023-03-15' => '152.9900',
                    '2023-03-16' => '155.8500',
                    '2023-03-17' => '155.0000',
                    '2023-03-20' => '157.4000',
                    '2023-03-21' => '159.2800',
                    '2023-03-22' => '157.8300',
                    '2023-03-23' => '158.9300',
                    '2023-03-24' => '160.2500',
                    '2023-03-27' => '158.2800',
                    '2023-03-28' => '157.6500',
                    '2023-03-29' => '160.7700',
                    '2023-03-30' => '162.3600',
                    '2023-03-31' => '164.9000',
                    '2023-04-03' => '166.1700',
                    '2023-04-04' => '165.6300',
                    '2023-04-05' => '163.7600',
                    '2023-04-06' => '164.6600',
                    '2023-04-10' => '162.0300',
                    '2023-04-11' => '160.8000',
                    '2023-04-12' => '160.1000',
                    '2023-04-13' => '165.5600',
                    '2023-04-14' => '165.2100',
                    '2023-04-17' => '165.2300',
                    '2023-04-18' => '166.4700',
                    '2023-04-19' => '167.6300',
                    '2023-04-20' => '166.6500',
                    '2023-04-21' => '165.0200',
                    '2023-04-24' => '165.3300',
                    '2023-04-25' => '163.7700',
                    '2023-04-26' => '163.7600',
                    '2023-04-27' => '168.4100',
                    '2023-04-28' => '169.6800',
                    '2023-05-01' => '169.5900',
                    '2023-05-02' => '168.5400',
                    '2023-05-03' => '167.4500',
                    '2023-05-04' => '165.7900',
                    '2023-05-05' => '173.5700',
                    '2023-05-08' => '173.5000',
                    '2023-05-09' => '171.7700',
                    '2023-05-10' => '173.5550',
                    '2023-05-11' => '173.7500',
                    '2023-05-12' => '172.5700',
                    '2023-05-15' => '172.0700',
                    '2023-05-16' => '172.0700',
                    '2023-05-17' => '172.6900',
                    '2023-05-18' => '175.0500',
                    '2023-05-19' => '175.1600',
                    '2023-05-22' => '174.2000',
                    '2023-05-23' => '171.5600',
                    '2023-05-24' => '171.8400',
                    '2023-05-25' => '172.9900',
                    '2023-05-26' => '175.4300',
                    '2023-05-30' => '177.3000',
                    '2023-05-31' => '177.2500',
                    '2023-06-01' => '180.0900',
                    '2023-06-02' => '180.9500',
                    '2023-06-05' => '179.5800',
                    '2023-06-06' => '179.2100',
                    '2023-06-07' => '177.8200',
                    '2023-06-08' => '180.5700',
                    '2023-06-09' => '180.9600',
                    '2023-06-12' => '183.7900',
                    '2023-06-13' => '183.3100',
                    '2023-06-14' => '183.9500',
                    '2023-06-15' => '186.0100',
                    '2023-06-16' => '184.9200',
                ],
                'expected' => [
                    '2023-01-25' => null,
                    '2023-01-26' => null,
                    '2023-01-27' => null,
                    '2023-01-30' => null,
                    '2023-01-31' => null,
                    '2023-02-01' => null,
                    '2023-02-02' => null,
                    '2023-02-03' => null,
                    '2023-02-06' => null,
                    '2023-02-07' => null,
                    '2023-02-08' => null,
                    '2023-02-09' => null,
                    '2023-02-10' => null,
                    '2023-02-13' => null,
                    '2023-02-14' => null,
                    '2023-02-15' => null,
                    '2023-02-16' => null,
                    '2023-02-17' => null,
                    '2023-02-21' => null,
                    '2023-02-22' => null,
                    '2023-02-23' => null,
                    '2023-02-24' => null,
                    '2023-02-27' => null,
                    '2023-02-28' => null,
                    '2023-03-01' => null,
                    '2023-03-02' => null,
                    '2023-03-03' => null,
                    '2023-03-06' => null,
                    '2023-03-07' => null,
                    '2023-03-08' => null,
                    '2023-03-09' => null,
                    '2023-03-10' => null,
                    '2023-03-13' => null,
                    '2023-03-14' => null,
                    '2023-03-15' => null,
                    '2023-03-16' => null,
                    '2023-03-17' => null,
                    '2023-03-20' => null,
                    '2023-03-21' => null,
                    '2023-03-22' => null,
                    '2023-03-23' => null,
                    '2023-03-24' => null,
                    '2023-03-27' => null,
                    '2023-03-28' => null,
                    '2023-03-29' => null,
                    '2023-03-30' => null,
                    '2023-03-31' => null,
                    '2023-04-03' => null,
                    '2023-04-04' => null,
                    '2023-04-05' => null,
                    '2023-04-06' => null,
                    '2023-04-10' => null,
                    '2023-04-11' => null,
                    '2023-04-12' => null,
                    '2023-04-13' => null,
                    '2023-04-14' => null,
                    '2023-04-17' => null,
                    '2023-04-18' => null,
                    '2023-04-19' => null,
                    '2023-04-20' => null,
                    '2023-04-21' => null,
                    '2023-04-24' => null,
                    '2023-04-25' => null,
                    '2023-04-26' => null,
                    '2023-04-27' => null,
                    '2023-04-28' => null,
                    '2023-05-01' => null,
                    '2023-05-02' => null,
                    '2023-05-03' => null,
                    '2023-05-04' => null,
                    '2023-05-05' => null,
                    '2023-05-08' => null,
                    '2023-05-09' => '157.2289',
                    '2023-05-10' => '157.4525',
                    '2023-05-11' => '157.6758',
                    '2023-05-12' => '157.8798',
                    '2023-05-15' => '158.0742',
                    '2023-05-16' => '158.2659',
                    '2023-05-17' => '158.4635',
                    '2023-05-18' => '158.6907',
                    '2023-05-19' => '158.9163',
                    '2023-05-22' => '159.1257',
                    '2023-05-23' => '159.2960',
                    '2023-05-24' => '159.4679',
                    '2023-05-25' => '159.6531',
                    '2023-05-26' => '159.8692',
                    '2023-05-30' => '160.1080',
                    '2023-05-31' => '160.3428',
                    '2023-06-01' => '160.6133',
                    '2023-06-02' => '160.8919',
                    '2023-06-05' => '161.1479',
                    '2023-06-06' => '161.3954',
                    '2023-06-07' => '161.6204',
                    '2023-06-08' => '161.8799',
                    '2023-06-09' => '162.1413',
                    '2023-06-12' => '162.4379',
                    '2023-06-13' => '162.7238',
                    '2023-06-14' => '163.0146',
                    '2023-06-15' => '163.3296',
                    '2023-06-16' => '163.6253',
                ],
            ],
            'WSMA 120 days' => [
                'period'   => 120,
                'values'   => [
                    '2023-01-25' => '141.8600',
                    '2023-01-26' => '143.9600',
                    '2023-01-27' => '145.9300',
                    '2023-01-30' => '143.0000',
                    '2023-01-31' => '144.2900',
                    '2023-02-01' => '145.4300',
                    '2023-02-02' => '150.8200',
                    '2023-02-03' => '154.5000',
                    '2023-02-06' => '151.7300',
                    '2023-02-07' => '154.6500',
                    '2023-02-08' => '151.9200',
                    '2023-02-09' => '150.8700',
                    '2023-02-10' => '151.0100',
                    '2023-02-13' => '153.8500',
                    '2023-02-14' => '153.2000',
                    '2023-02-15' => '155.3300',
                    '2023-02-16' => '153.7100',
                    '2023-02-17' => '152.5500',
                    '2023-02-21' => '148.4800',
                    '2023-02-22' => '148.9100',
                    '2023-02-23' => '149.4000',
                    '2023-02-24' => '146.7100',
                    '2023-02-27' => '147.9200',
                    '2023-02-28' => '147.4100',
                    '2023-03-01' => '145.3100',
                    '2023-03-02' => '145.9100',
                    '2023-03-03' => '151.0300',
                    '2023-03-06' => '153.8300',
                    '2023-03-07' => '151.6000',
                    '2023-03-08' => '152.8700',
                    '2023-03-09' => '150.5900',
                    '2023-03-10' => '148.5000',
                    '2023-03-13' => '150.4700',
                    '2023-03-14' => '152.5900',
                    '2023-03-15' => '152.9900',
                    '2023-03-16' => '155.8500',
                    '2023-03-17' => '155.0000',
                    '2023-03-20' => '157.4000',
                    '2023-03-21' => '159.2800',
                    '2023-03-22' => '157.8300',
                    '2023-03-23' => '158.9300',
                    '2023-03-24' => '160.2500',
                    '2023-03-27' => '158.2800',
                    '2023-03-28' => '157.6500',
                    '2023-03-29' => '160.7700',
                    '2023-03-30' => '162.3600',
                    '2023-03-31' => '164.9000',
                    '2023-04-03' => '166.1700',
                    '2023-04-04' => '165.6300',
                    '2023-04-05' => '163.7600',
                    '2023-04-06' => '164.6600',
                    '2023-04-10' => '162.0300',
                    '2023-04-11' => '160.8000',
                    '2023-04-12' => '160.1000',
                    '2023-04-13' => '165.5600',
                    '2023-04-14' => '165.2100',
                    '2023-04-17' => '165.2300',
                    '2023-04-18' => '166.4700',
                    '2023-04-19' => '167.6300',
                    '2023-04-20' => '166.6500',
                    '2023-04-21' => '165.0200',
                    '2023-04-24' => '165.3300',
                    '2023-04-25' => '163.7700',
                    '2023-04-26' => '163.7600',
                    '2023-04-27' => '168.4100',
                    '2023-04-28' => '169.6800',
                    '2023-05-01' => '169.5900',
                    '2023-05-02' => '168.5400',
                    '2023-05-03' => '167.4500',
                    '2023-05-04' => '165.7900',
                    '2023-05-05' => '173.5700',
                    '2023-05-08' => '173.5000',
                    '2023-05-09' => '171.7700',
                    '2023-05-10' => '173.5550',
                    '2023-05-11' => '173.7500',
                    '2023-05-12' => '172.5700',
                    '2023-05-15' => '172.0700',
                    '2023-05-16' => '172.0700',
                    '2023-05-17' => '172.6900',
                    '2023-05-18' => '175.0500',
                    '2023-05-19' => '175.1600',
                    '2023-05-22' => '174.2000',
                    '2023-05-23' => '171.5600',
                    '2023-05-24' => '171.8400',
                    '2023-05-25' => '172.9900',
                    '2023-05-26' => '175.4300',
                    '2023-05-30' => '177.3000',
                    '2023-05-31' => '177.2500',
                    '2023-06-01' => '180.0900',
                    '2023-06-02' => '180.9500',
                    '2023-06-05' => '179.5800',
                    '2023-06-06' => '179.2100',
                    '2023-06-07' => '177.8200',
                    '2023-06-08' => '180.5700',
                    '2023-06-09' => '180.9600',
                    '2023-06-12' => '183.7900',
                    '2023-06-13' => '183.3100',
                    '2023-06-14' => '183.9500',
                    '2023-06-15' => '186.0100',
                    '2023-06-16' => '184.9200',
                ],
                'expected' => [
                    '2023-01-25' => null,
                    '2023-01-26' => null,
                    '2023-01-27' => null,
                    '2023-01-30' => null,
                    '2023-01-31' => null,
                    '2023-02-01' => null,
                    '2023-02-02' => null,
                    '2023-02-03' => null,
                    '2023-02-06' => null,
                    '2023-02-07' => null,
                    '2023-02-08' => null,
                    '2023-02-09' => null,
                    '2023-02-10' => null,
                    '2023-02-13' => null,
                    '2023-02-14' => null,
                    '2023-02-15' => null,
                    '2023-02-16' => null,
                    '2023-02-17' => null,
                    '2023-02-21' => null,
                    '2023-02-22' => null,
                    '2023-02-23' => null,
                    '2023-02-24' => null,
                    '2023-02-27' => null,
                    '2023-02-28' => null,
                    '2023-03-01' => null,
                    '2023-03-02' => null,
                    '2023-03-03' => null,
                    '2023-03-06' => null,
                    '2023-03-07' => null,
                    '2023-03-08' => null,
                    '2023-03-09' => null,
                    '2023-03-10' => null,
                    '2023-03-13' => null,
                    '2023-03-14' => null,
                    '2023-03-15' => null,
                    '2023-03-16' => null,
                    '2023-03-17' => null,
                    '2023-03-20' => null,
                    '2023-03-21' => null,
                    '2023-03-22' => null,
                    '2023-03-23' => null,
                    '2023-03-24' => null,
                    '2023-03-27' => null,
                    '2023-03-28' => null,
                    '2023-03-29' => null,
                    '2023-03-30' => null,
                    '2023-03-31' => null,
                    '2023-04-03' => null,
                    '2023-04-04' => null,
                    '2023-04-05' => null,
                    '2023-04-06' => null,
                    '2023-04-10' => null,
                    '2023-04-11' => null,
                    '2023-04-12' => null,
                    '2023-04-13' => null,
                    '2023-04-14' => null,
                    '2023-04-17' => null,
                    '2023-04-18' => null,
                    '2023-04-19' => null,
                    '2023-04-20' => null,
                    '2023-04-21' => null,
                    '2023-04-24' => null,
                    '2023-04-25' => null,
                    '2023-04-26' => null,
                    '2023-04-27' => null,
                    '2023-04-28' => null,
                    '2023-05-01' => null,
                    '2023-05-02' => null,
                    '2023-05-03' => null,
                    '2023-05-04' => null,
                    '2023-05-05' => null,
                    '2023-05-08' => null,
                    '2023-05-09' => null,
                    '2023-05-10' => null,
                    '2023-05-11' => null,
                    '2023-05-12' => null,
                    '2023-05-15' => null,
                    '2023-05-16' => null,
                    '2023-05-17' => null,
                    '2023-05-18' => null,
                    '2023-05-19' => null,
                    '2023-05-22' => null,
                    '2023-05-23' => null,
                    '2023-05-24' => null,
                    '2023-05-25' => null,
                    '2023-05-26' => null,
                    '2023-05-30' => null,
                    '2023-05-31' => null,
                    '2023-06-01' => null,
                    '2023-06-02' => null,
                    '2023-06-05' => null,
                    '2023-06-06' => null,
                    '2023-06-07' => null,
                    '2023-06-08' => null,
                    '2023-06-09' => null,
                    '2023-06-12' => null,
                    '2023-06-13' => null,
                    '2023-06-14' => null,
                    '2023-06-15' => null,
                    '2023-06-16' => null,
                ],
            ],
        ];
    }
}
