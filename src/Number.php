<?php declare(strict_types=1);

namespace Kensho\Chart;

use InvalidArgumentException;
use Stringable;
use function bcadd;
use function bccomp;
use function bcdiv;
use function bcmul;
use function bcsub;
use function floatval;
use function number_format;
use function preg_match;
use function strval;

/**
 * Keeps numbers as strings internally for
 * arbitrary precision calculations. Just a
 * thin wrapper for BCMath.
 */
final readonly class Number implements Stringable
{
    private const int SCALE = 16;

    private string $value;

    public function __construct(string|int $value)
    {
        $this->value = $this->parse(value: $value);
    }

    private function parse(self|string|int $value): string
    {
        if ($value instanceof self) {
            return $value->__toString();
        } else {
            $parsed = strval(value: $value);

            if (!preg_match(
                pattern: '/^[+-]?[0-9]*(\.[0-9]*)?$/',
                subject: $parsed
            )) {
                throw new InvalidArgumentException(
                    message: 'Invalid number.'
                );
            }
            return $parsed;
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function plus(self|string|int $value): self
    {
        $value  = $this->parse(value: $value);
        $result = bcadd(num1: $this->value, num2: $value, scale: self::SCALE);

        return new self(value: $result);
    }

    public function minus(self|string|int $value): self
    {
        $value  = $this->parse(value: $value);
        $result = bcsub(num1: $this->value, num2: $value, scale: self::SCALE);

        return new self(value: $result);
    }

    public function multipliedBy(self|string|int $value): self
    {
        $value  = $this->parse(value: $value);
        $result = bcmul(num1: $this->value, num2: $value, scale: self::SCALE);

        return new self(value: $result);
    }

    public function dividedBy(self|string|int $value): self
    {
        $value  = $this->parse(value: $value);
        $result = bcdiv(num1: $this->value, num2: $value, scale: self::SCALE);

        return new self(value: $result);
    }

    public function abs(): self
    {
        $isNegative = $this->isNegative();

        if ($isNegative) {
            $result = bcmul(num1: $this->value, num2: '-1', scale: self::SCALE);

            return new self(value: $result);
        }
        return $this;
    }

    public function isZero(): bool
    {
        $result = bccomp(num1: $this->value, num2: '0', scale: self::SCALE);

        return $result === 0;
    }

    public function isPositive(): bool
    {
        $result = bccomp(num1: $this->value, num2: '0', scale: self::SCALE);

        return $result === 1;
    }

    public function isNegative(): bool
    {
        $result = bccomp(num1: $this->value, num2: '0', scale: self::SCALE);

        return $result === -1;
    }

    public function isGreaterThan(self|string|int $value): bool
    {
        $value  = $this->parse(value: $value);
        $result = bccomp(num1: $this->value, num2: $value, scale: self::SCALE);

        return $result === 1;
    }

    public function isLessThan(self|string|int $value): bool
    {
        $value  = $this->parse(value: $value);
        $result = bccomp(num1: $this->value, num2: $value, scale: self::SCALE);

        return $result === -1;
    }

    public function round(int $scale): string
    {
        $number = floatval(value: $this->value);

        return number_format(num: $number, decimals: $scale, thousands_separator: '');
    }
}
