<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

interface LengthRule
{
    public function min($min);
    public function max($max);
    public function assertLength($value): int;
}
