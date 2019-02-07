<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Number extends Assertion implements RangeRule
{
    public function __construct($min = null, $max = null)
    {
        if ($min !== null) {
            $this->attributes['min'] = $min;
        }

        if ($max !== null) {
            $this->attributes['max'] = $max;
        }
    }

    public function min($min): self
    {
        $this->attributes['min'] = $min;

        return $this;
    }

    public function max($max): self
    {
        $this->attributes['max'] = $max;

        return $this;
    }

    public function assertRange($number): int
    {
        if (function_exists('bccomp')) {
            return $this->assertRangeWithBcMath($number);
        }

        if (isset($this->attributes['min']) && $number < $this->attributes['min']) {
            return -1;
        }

        if (isset($this->attributes['max']) && $number > $this->attributes['max']) {
            return 1;
        }

        return 0;
    }

    private function assertRangeWithBcMath($number): int
    {
        if (isset($this->attributes['min']) && bccomp((string) $number, (string) $this->attributes['min']) < 0) {
            return -1;
        }

        if (isset($this->attributes['max']) && bccomp((string) $number, (string) $this->attributes['max']) > 0) {
            return 1;
        }

        return 0;
    }

    protected function assert($input): bool
    {
        return is_numeric($input);
    }
}
