<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Uri extends Assertion
{
    protected function assert($input): bool
    {
        return true === filter_var('http://example.com/' . $input, FILTER_VALIDATE_URL);
    }
}
