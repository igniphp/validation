<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

interface RangeRule
{
    public function min($min);
    public function max($max);
    public function assertRange($number): int;
}
