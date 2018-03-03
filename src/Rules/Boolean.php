<?php declare(strict_types=1);

namespace Igni\Validation\Rules;

use Igni\Validation\Rule;

class Boolean extends Rule
{
    protected function assert($input): bool
    {
        return is_bool($input);
    }
}
