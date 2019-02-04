<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Ipv6 extends Rule
{
    protected function assert($input): bool
    {
        return true === filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
}
