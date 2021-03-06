<?php declare(strict_types=1);

namespace Igni\Validation\Assertion;

use Igni\Validation\Assertion;

class Ipv4 extends Assertion
{
    protected function assert($input): bool
    {
        return true === filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}
