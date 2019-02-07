<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Truthy extends Assertion
{
    protected function assert($input): bool
    {
        return true === filter_var($input, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
