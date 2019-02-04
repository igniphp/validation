<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Ipv4 extends Rule
{
    protected function assert($input): bool
    {
        return true === filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
    }
}
