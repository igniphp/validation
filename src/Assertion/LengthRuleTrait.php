<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Exception\InvalidArgumentException;

/**
 * @uses AbstractRule::$attributes
 */
trait LengthRuleTrait
{
    public function setExpectedLength(int $min = null, int $max = null): void
    {
        if ($min !== null) {
            $this->attributes['min'] = $min;
        }

        if ($max !== null) {
            $this->attributes['max'] = $max;
        }

        if ($min > $max) {
            throw InvalidArgumentException::forInvalidLengthSet();
        }
    }

    public function min($min): self
    {
        $this->attributes['min'] = $min;

        return $this;
    }

    public function max($max): self
    {
        $this->attributes['max']= $max;

        return $this;
    }

    public function assertLength($value): int
    {
        $length = 0;

        if (is_string($value)) {
            $length = strlen($value);
        } elseif (is_array($value) || $value instanceof \Countable) {
            $length = count($value);
        }

        if (isset($this->attributes['min']) && $length < $this->attributes['min']) {
            return -1;
        }

        if (isset($this->attributes['max']) && $length > $this->attributes['max']) {
            return 1;
        }

        return 0;
    }
}
