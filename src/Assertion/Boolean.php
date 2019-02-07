<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Boolean extends Assertion
{
    protected function assert($input): bool
    {
        return is_bool($input);
    }
}
