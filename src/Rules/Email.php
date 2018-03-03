<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Email extends Rule
{
    protected function assert($input): bool
    {
        return is_string($input) && filter_var($input, FILTER_VALIDATE_EMAIL);
    }
}
