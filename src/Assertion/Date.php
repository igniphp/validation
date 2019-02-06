<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use InvalidArgumentException;
use Igni\Validation\Assertion;
use DateTime;
use DateTimeInterface;

class Date extends Assertion implements RangeRule
{
    public function __construct(string $format = null, DateTimeInterface $min = null, DateTimeInterface $max = null)
    {
        if ($format !== null) {
            $this->attributes['format'] = $format;
        }

        if ($max !== null) {
            $this->max($max);
        }

        if ($min !== null) {
            $this->min($min);
        }
    }

    public function min($value): Date
    {
        if (!$value instanceof DateTimeInterface) {
            throw new InvalidArgumentException('$value must be an instance of DateTimeInterface');
        }

        $this->attributes['min'] = $value;

        return $this;
    }

    public function max($value): Date
    {
        if (!$value instanceof DateTimeInterface) {
            throw new InvalidArgumentException('$value must be an instance of DateTimeInterface');
        }

        $this->attributes['max'] = $value;

        return $this;
    }

    public function assertRange($input): int
    {
        if (!$input instanceof DateTime) {
            if (isset($this->attributes['format'])) {
                $input = DateTime::createFromFormat(
                    $this->attributes['format'],
                    $input
                );
            } elseif (is_string($input)) {
                $input = new DateTime($input);
            } else {
                throw new InvalidArgumentException("${input} is not valid date expression.");
            }
        }

        if (isset($this->attributes['min']) && $input < $this->attributes['min']) {
            return -1;
        }

        if (isset($this->attributes['max']) && $input > $this->attributes['max']) {
            return 1;
        }

        return 0;
    }

    public function format(string $format): Date
    {
        $this->attributes['format'] = $format;

        return $this;
    }

    protected function assert($input): bool
    {
        if ($input instanceof DateTime) {
            return true;
        } elseif (!is_string($input)) {
            return false;
        } elseif (empty($this->attributes['format'])) {
            return false !== strtotime($input);
        }

        $info = date_parse_from_format($this->attributes['format'], $input);

        return ($info['error_count'] === 0 && $info['warning_count'] === 0);
    }
}
