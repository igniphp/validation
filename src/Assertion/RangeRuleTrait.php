<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;
use Igni\Validation\Exception\InvalidArgumentException;

/**
 * @uses AbstractRule::$attributes
 */
trait RangeRuleTrait
{
    public function setExpectedRange($min = null, $max = null): void
    {
        if ($min !== null) {
            $this->attributes['min'] = $min;
        }

        if ($max !== null) {
            $this->attributes['max'] = $max;
        }

        if ($min > $max) {
            InvalidArgumentException::forInvalidRangeSet();
        }
    }

    public function min($min)
    {
        $this->attributes['min'] = $min;

        return $this;
    }

    public function max($max)
    {
        $this->attributes['max'] = $max;

        return $this;
    }

    public function assertRange($value): int
    {
        if (isset($this->attributes['min']) && $value < $this->attributes['min']) {
            return -1;
        }

        if (isset($this->attributes['max']) && $value > $this->attributes['max']) {
            return 1;
        }

        return 0;
    }
}
