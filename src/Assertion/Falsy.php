<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Falsy extends Assertion
{
    protected function assert($input): bool
    {
        return false === filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
